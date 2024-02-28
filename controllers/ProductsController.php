<?php

namespace app\controllers;

use Yii;
use app\models\SubProducts;
use app\models\searches\SubProductsSearch;
use app\models\Products;
use app\models\searches\ProductsSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductsController implements the CRUD actions for Products model.
 */
class ProductsController extends Controller
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
     * Lists all Products models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Products model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $searchModelSubProduct = new SubProductsSearch();
        $dataProvider = $searchModelSubProduct->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $this->findProductsModel($id),
            'searchModel' => $searchModelSubProduct,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new Products model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Products();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->stock_quantity)) {
                $model->stock_quantity = 0;
            }
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Products model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findProductsModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Products model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
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
     * Finds the Products model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Products the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProductsModel($id)
    {
        if (($model = Products::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


//    SUB ITEMS!!!
    public function actionSubItemsView($id = NULL)
    {
        if (!empty($id))
        {
            return $this->render('viewsub', [
                'model' => $this->findSubItemsModel($id),
            ]);
        }
    }

    public function actionSubItemsUpdate($id)
    {
        $modelSubItems = $this->findSubItemsModel($id);
        $modelProducts = $this->findProductsModel($modelSubItems->product_id);

        $modelProducts->stock_quantity = intval($modelProducts->stock_quantity) - intval($modelSubItems->quantity);

        if ($modelSubItems->load(Yii::$app->request->post()) && $modelSubItems->save()) {
            $modelProducts->stock_quantity = intval($modelProducts->stock_quantity) + intval($modelSubItems->quantity);
            $modelProducts->save();

            return $this->redirect(['sub-items-view', 'id' => $modelSubItems->id]);
        }

        return $this->render('updatesub', [
            'model' => $modelSubItems,
        ]);
    }

    public function actionSubItemsDelete(){
        Yii::$app->session->setFlash('error', [
            'title' => 'Oh no!',
            'body' => 'You do not have permission to delete this item.',
        ]);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionSubItemsCreate($id){

        $model = new SubProducts();
        $modelProducts = $this->findProductsModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $modelProducts->stock_quantity = intval($modelProducts->stock_quantity) + intval($model->quantity);
            $modelProducts->save();
            return $this->redirect(['sub-items-view', 'id' => $model->id]);
        }

        return $this->render('createsub', [
            'model' => $model,
            'productmodel' => $modelProducts,
        ]);
    }

    protected function findSubItemsModel($id)
    {
        if (($model = SubProducts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
