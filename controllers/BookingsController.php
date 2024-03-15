<?php

namespace app\controllers;

use app\models\BookingsServices;
use app\models\BookingsTiming;
use app\models\Employees;
use app\models\EmployeeSelectionForm;
use app\models\Payments;
use app\models\Services;
use Yii;
use app\models\Bookings;
use app\models\searches\BookingsSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
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
            // Get the selected services from the form submission
            $selectedServices = Yii::$app->request->post('selectedServices');

            if (empty($selectedServices)) {
                Yii::$app->session->setFlash('error', [
                    'title' => 'Oh no!',
                    'body' => 'Please select at least one service.',
                ]);
            } else {
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

    public function actionOngoing($id)
    {
        date_default_timezone_set('Asia/Manila');
        $bookingModel  = $this->findModel($id);

        $employeeSelectionModel = new EmployeeSelectionForm();
        $timing = new BookingsTiming();

        if ($employeeSelectionModel->load(Yii::$app->request->post()) && $employeeSelectionModel->validate()) {
            // Proceed with your logic here
            $bookingModel->fk_booking_status = 2;

            $timing->fk_employee = $employeeSelectionModel->selectEmployee;
            $timing->fk_booking = $bookingModel->id;
            $timing->booking_time = $bookingModel->schedule_time;
            if ($bookingModel->save() && $timing->save()) {
                return $this->redirect(['view', 'id' => $bookingModel->id]);
            }
        }
        return $this->render('ongoing', [
            'employeeSelectionModel' => $employeeSelectionModel,
            'bookingModel' => $bookingModel,
        ]);
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
    public function actionComplete($id)
    {
        $model = $this->findModel($id);
        $model->fk_booking_status = 3; // Assuming 3 represents the "Complete" status

        if ($model->save()) {
            Yii::$app->session->setFlash('success', [
                'title' => 'Yay!',
                'body' => 'Booking has been completed successfully.',
            ]);
        } else {
            Yii::$app->session->setFlash('error', [
                'title' => 'Yay!',
                'body' => 'Failed to complete booking.',
            ]);
        }

        return $this->redirect(['index']);
    }

    public function actionPayments($id)
    {
        $modelPayment = new Payments();
        $dataProvider = new ActiveDataProvider([
            'query' => BookingsServices::find()->where(['fk_booking' => $id]),
        ]);

        if ($modelPayment->load(Yii::$app->request->post()) && $modelPayment->save()) {
            Yii::$app->session->setFlash('success', 'Payment created successfully.');
            return $this->redirect(['view', 'id' => $modelPayment->id]);
        }

        return $this->render('payments', [
            'paymentModel' => $modelPayment,
            'dataProvider' => $dataProvider,
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
}
