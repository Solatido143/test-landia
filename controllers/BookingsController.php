<?php

namespace app\controllers;

use app\models\BookingsServices;
use app\models\BookingsTiming;
use app\models\Employees;
use app\models\EmployeeSelectionForm;
use app\models\Payments;
use app\models\Promos;
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

    /**
     * Lists all Bookings models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookingsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bookings model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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
            $waiting_time = intval(($min_waiting_time + $serviceInqueueTime) / $employees_waiting_time_count) . ' to ' . intval(($max_waiting_time + $serviceInqueueTime) / $employees_waiting_time_count);

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

        // Find the promo by ID
        $promo = Promos::findOne($promoId);

        // Check if promo exists
        if ($promo !== null) {
            // Return the promo's percentage discount
            return $promo->percentage;
        } else {
            // Promo not found, return 0
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
        $model = new Bookings();
        $services = Services::find()->all();

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
//                $existingBooking = Bookings::find()
//                    ->where(['fk_customer' => $model->fk_customer])
//                    ->one();
//                if ($existingBooking !== null) {
//                    Yii::$app->session->setFlash('error', [
//                        'title' => 'Error!',
//                        'body' => 'The customer already has a booking.',
//                    ]);
//                    return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
//                }
                // Validate and save the model
                if ($model->validate() && $model->save()) {
                    // Iterate through selected services and save them to the bookings_services table
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
            'services' => $services,
        ]);
    }

    /**
     * Updates an existing Bookings model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $servicesModel = new Services();
        $services = Services::find()->all();

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
            'servicesModel' => $servicesModel,
            'services' => $services,
        ]);
    }

    public function actionBookingServices($fk_booking)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $booking_services = BookingsServices::find()->where(['fk_booking' => $fk_booking])->all();
        return $booking_services;
    }


    /**
     * Deletes an existing Bookings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->session->setFlash('error', [
            'title' => 'Oh no!',
            'body' => 'You do not have enough permission.',
        ]);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Finds the Bookings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Bookings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bookings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
