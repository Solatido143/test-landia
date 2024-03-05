<?php

namespace app\controllers;

use app\models\Employees;
use Yii;
use app\models\Attendances;
use app\models\searches\AttendancesSearch as AttendancesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AttendancesController implements the CRUD actions for AttendancesSearch model.
 */
class AttendancesController extends Controller
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
     * Lists all AttendancesSearch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AttendancesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AttendancesSearch model.
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
     * Creates a new AttendancesSearch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        date_default_timezone_set('Asia/Manila');

        $fkEmployeeId = Yii::$app->user->identity->fk_employee_id;
        if ($fkEmployeeId === null) {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'Fk Employee is null.',
            ]);
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        $employee = Employees::findOne(['employee_id' => $fkEmployeeId]);
        if ($employee === null) {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'No employee found.',
            ]);
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        // Check if the employee has an attendance record for today with no sign-out time
        $existingAttendance = Attendances::find()
            ->where([
                'fk_employee' => $employee->id,
                'date' => date('Y-m-d'),
                'sign_out' => ''
            ])
            ->exists();

        if ($existingAttendance) {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'Employee already has an attendance record for today.',
            ]);
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }

        $model = new Attendances();
        $model->fk_employee = $employee->id;
        $model->sign_in = date('H:i');
        $model->sign_in_log = "Time In";
        $model->date = date('m-d-Y');
        $model->sign_out = "";
        $model->remarks = "";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing AttendancesSearch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        date_default_timezone_set('Asia/Manila');

        $model = $this->findModel($id);

        $fkEmployeeId = $model->fk_employee;
        $employee = Employees::findOne(['id' => $fkEmployeeId]);
        if ($employee === null) {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'Employee not found.',
            ]);
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        $attendances = Attendances::find()
            ->where(['fk_employee' => $employee->id])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if ($attendances === null) {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'No attendance record found.',
            ]);
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }
        if (!empty($attendances->sign_out)) {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'Employee has already timed out.',
            ]);
            return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
        }

        $model->sign_out = date('H:i');
        $model->sign_out_log = "Time Out";

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionEdit($id)
    {
        Yii::$app->session->setFlash('error', [
            'title' => 'Oh no!',
            'body' => 'You do not have enough permission.',
        ]);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Deletes an existing AttendancesSearch model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        Yii::$app->session->setFlash('error', [
            'title' => 'Oh no!',
            'body' => 'You do not have permission to delete this item.',
        ]);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Finds the AttendancesSearch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Attendances the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Attendances::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
