<?php

namespace app\controllers;

use app\models\Cities;
use app\models\Clusters;
use app\models\Employees;
use app\models\Positions;
use app\models\Provinces;
use app\models\Regions;
use app\models\searches\EmployeesSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * EmployeesController implements the CRUD actions for Employees model.
 */
class EmployeesController extends Controller
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
     * Lists all Employees models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EmployeesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Employees model.
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
     * Creates a new Employees model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Employees();
        $model->logged_by = Yii::$app->user->identity->username;
        $model->logged_time = date('Y-m-d H:i:s');
        $model->updated_by = '';
        $model->updated_time = '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Employees model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Employees model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        Yii::$app->session->setFlash('error', [
            'title' => 'Oh no!',
            'body' => 'You do not have permission to delete this item..',
        ]);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    /**
     * Finds the Employees model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Employees the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Employees::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetPositionAvailability($id)
    {
        $position = Positions::findOne($id);
        if ($position) {
            $availabilityText = $position->availability ? '1' : '0';
            return $availabilityText;
        } else {
            return '';
        }
    }

    public function actionGetRegions($id)
    {
        // Fetch regions associated with the selected cluster
        $regions = Regions::find()->where(['fk_cluster' => $id])->all();

        // Generate dropdown options
        $options = '<option value>-- Select Region</option>';
        foreach ($regions as $region) {
            $options .= '<option value="' . $region->id . '">' . $region->region . '</option>';
        }

        // Return dropdown options
        return $options;
    }

    public function actionGetProvinces($id)
    {
        // Fetch regions associated with the selected cluster
        $provinces = Provinces::find()->where(['fk_region' => $id])->all();

        // Generate dropdown options
        $options = '<option value>-- Select Province</option>';
        foreach ($provinces as $province) {
            $options .= '<option value="' . $province->id . '">' . $province->province . '</option>';
        }

        // Return dropdown options
        return $options;
    }

    public function actionGetCities($id)
    {
        // Fetch regions associated with the selected cluster
        $cities = Cities::find()->where(['fk_province' => $id])->all();

        // Generate dropdown options
        $options = '<option value>-- Select City</option>';
        foreach ($cities as $city) {
            $options .= '<option value="' . $city->id . '">' . $city->city . '</option>';
        }

        // Return dropdown options
        return $options;
    }

}
