<?php

namespace app\controllers;

use app\models\InventoryUpdates;
use Yii;
use app\models\SubProducts;
use app\models\searches\SubProductsSearch;
use app\models\Products;
use app\models\searches\ProductsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ProductsController extends Controller
{

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

    public function actionIndex()
    {
        $searchModel = new ProductsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $productModel = $this->findProductsModel($id);
        $searchModelSubProduct = new SubProductsSearch();
        $dataProvider = $searchModelSubProduct->search(Yii::$app->request->queryParams);

        return $this->render('view', [
            'model' => $productModel,
            'searchModel' => $searchModelSubProduct,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Products();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionUpdate($id)
    {
        $model = $this->findProductsModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if (empty($model->fk_item_status)) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', [
                        'title' => 'Yay',
                        'body' => 'Successfully updated product - <b>' . $model->product_name . '</b>',
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }

            if ($model->fk_item_status == 1) {
                $model->stock_quantity += intval($model->new_stock_quantity);
                Yii::$app->session->setFlash('success', [
                    'title' => 'Yay',
                    'body' => 'Added '. $model->new_stock_quantity . ' to the stock quantity',
                ]);
            } else {
                $model->stock_quantity -= intval($model->new_stock_quantity);
                Yii::$app->session->setFlash('success', [
                    'title' => 'Yay',
                    'body' => 'Decrease '. $model->new_stock_quantity . ' to the stock quantity',
                ]);
            }
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }


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
        if (!empty($id)) {
            $model = $this->findSubItemsModel($id);
            if ($model !== null) {
                return $this->render('viewsub', [
                    'model' => $model,
                ]);
            } else {
                throw new \yii\web\NotFoundHttpException('The requested sub-item does not exist.');
            }
        } else {
            throw new \yii\web\BadRequestHttpException('No sub-item ID provided.');
        }
    }


    public function actionSubItemsUpdate($id)
    {
        $model = $this->findSubItemsModel($id);
        $modelProducts = $this->findProductsModel($model->product_id);

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->fk_item_status) && !empty($model->new_stock_quantity)) {
                Yii::$app->session->setFlash('error', [
                    'title' => 'Oh no!',
                    'body' => 'Select a status type for - <b>' . $model->sub_products_name . '</b>',
                ]);
                return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
            }

            if (empty($model->fk_item_status) && empty($model->new_stock_quantity)) {
                Yii::$app->session->setFlash('success', [
                    'title' => 'Yay',
                    'body' => 'Successfully updated product - <b>' . $model->sub_products_name . '</b>',
                ]);
                return $this->redirect(['view', 'id' => $modelProducts->id]);
            }

            $quantityChange = intval($model->new_stock_quantity);
            if ($model->fk_item_status == 1) {
                $model->quantity += $quantityChange;
                $modelProducts->stock_quantity += $quantityChange;
                $flashMessage = 'Added ' . $quantityChange . ' to the sub item quantity';
            } else {
                if ($model->quantity >= $quantityChange) {
                    $model->quantity -= $quantityChange;
                    $modelProducts->stock_quantity -= $quantityChange;
                    $flashMessage = 'Decreased ' . $quantityChange . ' from the sub item quantity';
                } else {
                    Yii::$app->session->setFlash('error', [
                        'title' => 'Oh no!',
                        'body' => 'The requested quantity cannot be decreased. Current quantity is too low.',
                    ]);
                    return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                }
            }

            Yii::$app->session->setFlash('success', [
                'title' => 'Yay',
                'body' => $flashMessage,
            ]);

            $model->save();
            $modelProducts->save();

            return $this->redirect(['view', 'id' => $modelProducts->id]);
        }

        return $this->render('updatesub', [
            'model' => $model,
        ]);
    }

    public function actionSubItemsDelete(){
        Yii::$app->session->setFlash('error', [
            'title' => 'Oh no!',
            'body' => 'You do not have permission to delete this item.',
        ]);
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
    }

    public function actionSubItemsCreate($id)
    {
        $modelSubProducts = new SubProducts();
        $modelProducts = $this->findProductsModel($id);

        $modelHasSub = SubProducts::find()
            ->where(['product_id' => $id])
            ->one();

        if ($modelSubProducts->load(Yii::$app->request->post()) && $modelSubProducts->save()) {
            if (empty($modelHasSub)) {
                $modelProducts->stock_quantity = intval($modelSubProducts->quantity);;
            } else {
                $modelProducts->stock_quantity = intval($modelProducts->stock_quantity) + intval($modelSubProducts->quantity);
            }
            $modelProducts->save();
            return $this->redirect(['view', 'id' => $modelProducts->id]);
        }

        return $this->render('createsub', [
            'model' => $modelSubProducts,
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
