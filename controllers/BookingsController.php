<?php

namespace app\controllers;

use app\models\BookingsServices;
use app\models\BookingsTiming;
use app\models\Employees;
use app\models\EmployeeSelectionForm;
use app\models\Payments;
use app\models\Promos;
use app\models\searches\Services as ServicesSearch;
use app\models\Services;
use app\models\WaitingTime;
use Yii;
use app\models\Bookings;
use app\models\searches\BookingsSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BookingsController implements the CRUD actions for Bookings model.
 */
class BookingsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($status = null)
    {
        $searchModel = new BookingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // If $status is provided and it's a valid integer between 1 and 5
        if (is_numeric($status)) {
            $dataProvider->query->andWhere(['fk_booking_status' => $status]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = Bookings::findOne($id);
        $bookingServices = new ActiveDataProvider([
            'query' => BookingsServices::find()->where(['fk_booking' => $id]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $bookingsTimingModel = BookingsTiming::findOne(['fk_booking' => $id]);
        if ($model === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        // Initialize $service outside the loop
        $serviceInqueueTime = 0;
        $serviceInqueueAll = 0;

        // Execute the SQL query to get min and max waiting times
        $min_waiting_time = WaitingTime::find()
            ->select('MIN(waiting_time)')
            ->scalar();
        $max_waiting_time = WaitingTime::find()
            ->select('MAX(waiting_time)')
            ->scalar();

        $employees_waiting_time_count = WaitingTime::find()
            ->select('COUNT(DISTINCT employee_name)')
            ->scalar();


        $bookingInqueueAllModel = Bookings::find()
            ->where(['fk_booking_status' => 1])
            ->all();
        foreach ($bookingInqueueAllModel as $bookingInqueueAll){
            $booking_Services = BookingsServices::find()
                ->where(['fk_booking' => $bookingInqueueAll->id])
                ->all();

            foreach ($booking_Services as $booking_Service) {
                $serviceInqueueAll += $booking_Service->fkService->completion_time;
            }
        }

        $bookingInqueueModel = Bookings::find()
            ->where(['fk_booking_status' => 1])
            ->andWhere(['not', ['id' => $id]])
            ->andWhere(['<', 'id', $id])
            ->all();

        foreach ($bookingInqueueModel as $bookingInqueue){
            $booking_Services = BookingsServices::find()
                ->where(['fk_booking' => $bookingInqueue->id])
                ->all();

            foreach ($booking_Services as $booking_Service) {
                $serviceInqueueTime += $booking_Service->fkService->completion_time;
            }
        }

        $bookingOngoingModel = Bookings::find()
            ->where(['fk_booking_status' => 2])
            ->all();

        if (empty($bookingOngoingModel)) {
            $waiting_time = $serviceInqueueTime;
        } else {
            if ($employees_waiting_time_count != 0) {
                $min_waiting_time = intval(($min_waiting_time + $serviceInqueueTime) / $employees_waiting_time_count);
                $max_waiting_time = intval(($max_waiting_time + $serviceInqueueTime) / $employees_waiting_time_count);
                $waiting_time = $min_waiting_time . ' to ' . $max_waiting_time;
            } else {
                $waiting_time = '0';
            }

            if ($min_waiting_time == $max_waiting_time) {
                $waiting_time = $min_waiting_time - $serviceInqueueAll + $serviceInqueueTime;
            }
            if (is_null($min_waiting_time)) {
                $waiting_time = '0';
            }
        }


        return $this->render('view', [
            'model' => $model,
            'bookingServices' => $bookingServices,
            'bookingsTimingModel' => $bookingsTimingModel,
            'waiting_time' => $waiting_time
        ]);
    }

    public function actionOngoing($id)
    {
        date_default_timezone_set('Asia/Manila');
        $bookingModel  = $this->findModel($id);

        $employeeSelectionModel = new EmployeeSelectionForm();
        $timing = new BookingsTiming();

        if ($employeeSelectionModel->load(Yii::$app->request->post()) && $employeeSelectionModel->validate()) {
            // Proceed with your logic here
            $bookingModel->fk_booking_status = 2;
            $bookingModel->updated_by = Yii::$app->user->identity->username;
            $bookingModel->updated_time = date('Y-m-d H:i:s');

            $timing->fk_employee = $employeeSelectionModel->selectEmployee;
            $timing->fk_booking = $bookingModel->id;
            $timing->booking_time = $bookingModel->logged_time;
            $timing->ongoing_time = date('Y-m-d H:i:s');

            if ($bookingModel->save() && $timing->save()) {
                return $this->redirect(['view', 'id' => $bookingModel->id]);
            }
        }
        return $this->render('ongoing', [
            'employeeSelectionModel' => $employeeSelectionModel,
            'bookingModel' => $bookingModel,
        ]);
    }

    public function actionPayments($id)
    {
        $modelPayment = new Payments();
        $bookingServices = new ActiveDataProvider([
            'query' => BookingsServices::find()->where(['fk_booking' => $id]),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $bookingModel = $this->findModel($id);

        if ($bookingModel === null) {
            throw new NotFoundHttpException('The requested booking does not exist.');
        }

        // Calculate the sum of fk_service
        $booking_services = BookingsServices::find()->where(['fk_booking' => $id])->all();
        $booking_timing = BookingsTiming::findOne(['fk_booking' => $id]);

        if ($booking_timing == null || $booking_services == null) {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'An Error Occurred.',
            ]);
            return $this->redirect(['view', 'id' => $id]);
        }

        $paymentTotal = 0.00;
        foreach ($booking_services as $booking_service)
        {
            $paymentTotal += $booking_service->fkService->service_fee;
        }

        $modelPayment->fk_booking = $id;
        $modelPayment->payment_date = date('Y-m-d');
        $modelPayment->payment_amount = $paymentTotal;
        $modelPayment->logged_by = Yii::$app->user->identity->username;
        $modelPayment->logged_time = date('H:i:s');

        if ($modelPayment->load(Yii::$app->request->post()) && $modelPayment->save()) {
            $booking_timing->completion_time = date('Y-m-d H:i:s');
            $bookingModel->fk_booking_status = 3;
            if ($bookingModel->save() && $booking_timing->save())
            {
                Yii::$app->session->setFlash('success', [
                    'title' => 'Yay!',
                    'body' => 'Payment created successfully.',
                ]);
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('payments', [
            'paymentModel' => $modelPayment,
            'dataProvider' => $bookingServices,
            'bookingModel' => $bookingModel,
        ]);
    }

    public function actionPromodiscount($promoId)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $promo = Promos::findOne($promoId);

        if ($promo !== null) {
            return $promo->percentage;
        } else {
            return 0;
        }
    }

    public function actionCancel($id)
    {
        $model = $this->findModel($id);
        $model->fk_booking_status = 4; // Set booking status to "Cancelled"

        if ($model->save()) {
            Yii::$app->session->setFlash('success', [
                'title' => 'Yay!',
                'body' => 'Booking has been cancelled successfully.',
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'Failed to cancel the booking.',
            ]);
        }

        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionCreate()
    {
        date_default_timezone_set('Asia/Manila');

        $query = Services::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        $model = new Bookings();

        $model->fk_booking_status = 1;
        $model->logged_by = Yii::$app->user->identity->username;
        $model->logged_time = date('Y-m-d H:i:s');
        $model->updated_by = '';
        $model->updated_time = '';

        if ($model->load(Yii::$app->request->post())) {
            $selectedServices = Yii::$app->request->post('selectedServices');

            if (empty($selectedServices)) {
                Yii::$app->session->setFlash('error', [
                    'title' => 'Oh no!',
                    'body' => 'Please select at least one service.',
                ]);
            } else {
                if ($model->validate() && $model->save()) {
                    foreach ($selectedServices as $serviceId) {
                        $bookingsServices = new BookingsServices();
                        $bookingsServices->fk_booking = $model->id;
                        $bookingsServices->fk_service = $serviceId;
                        $bookingsServices->save();
                    }
                    Yii::$app->session->setFlash('success', [
                        'title' => 'Yay!',
                        'body' => 'Booking Complete.',
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Failed to save booking.');
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $query = Services::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        // Get previously selected services directly from the BookingsServices table
        $previousSelectedServices = BookingsServices::find()
            ->select('fk_service')
            ->where(['fk_booking' => $model->id])
            ->column();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Get currently selected services
            $selectedServices = Yii::$app->request->post('selectedServices', []);

            // Check for newly checked services
            $newlyCheckedServices = array_diff($selectedServices, $previousSelectedServices);

            // Check for newly unchecked services
            $newlyUncheckedServices = array_diff($previousSelectedServices, $selectedServices);

            // Process newly checked services
            foreach ($newlyCheckedServices as $serviceId) {
                $bookingsServices = new BookingsServices();
                $bookingsServices->fk_booking = $model->id;
                $bookingsServices->fk_service = $serviceId;
                $bookingsServices->save();
            }

            // Process newly unchecked services
            foreach ($newlyUncheckedServices as $serviceId) {
                $bookingService = BookingsServices::findOne(['fk_booking' => $model->id, 'fk_service' => $serviceId]);
                if ($bookingService !== null) {
                    $bookingService->delete();
                }
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionBookingServices($fk_booking)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $booking_services = BookingsServices::find()->where(['fk_booking' => $fk_booking])->all();
        return $booking_services;
    }

    public function actionDelete($id)
    {
        Yii::$app->session->setFlash('error', [
            'title' => 'Oh no!',
            'body' => 'You do not have enough permission.',
        ]);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    protected function findModel($id)
    {
        if (($model = Bookings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
