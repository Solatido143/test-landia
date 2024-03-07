<?php

namespace app\controllers;

use app\models\BookingsServices;
use app\models\Services;
use Yii;
use app\models\Bookings;
use app\models\searches\BookingsSearch;
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

    /**
     * Creates a new Bookings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('Asia/Manila');
        $model = new Bookings();
        $services = Services::find()->all();

        $model->fk_booking_status = 1;
        $model->logged_by = Yii::$app->user->identity->username;
        $model->logged_time = date('Y-m-d h:i:s a');

        if ($model->load(Yii::$app->request->post())) {
            // Get the selected services from the form submission
            $selectedServices = Yii::$app->request->post('Bookings')['selectedServices'];

            // Now you can use $selectedServices to save to your database or perform other actions
            // For example, if you want to save to a related model:
            $bookingsServices = new BookingsServices();
            $bookingsServices->fk_service = $selectedServices;

            // Validate and save the model
            if ($model->validate() && $model->save()) {
                // Assign the booking ID to the related model
                $bookingsServices->fk_booking = $model->id;

                // Validate and save the related model
                if ($bookingsServices->validate() && $bookingsServices->save()) {
                    Yii::$app->session->setFlash('success', [
                        'title' => 'Yay!',
                        'body' => 'Booking Complete.',
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    // Handle errors in saving related model
                    Yii::$app->session->setFlash('error', 'Failed to save related services.');
                }
            } else {
                // Handle errors in saving main model
                Yii::$app->session->setFlash('error', 'Failed to save booking.');
            }
        }

        return $this->render('create', [
            'model' => $model,
            'services' => $services, // Pass services to the view
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
        $services = Services::find()->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'services' => $services,
        ]);
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
