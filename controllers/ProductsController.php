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

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->stock_quantity)){
                $model->stock_quantity = 0;
            }
            if ($this->validateProduct($model)) {
                if ($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function validateProduct($model)
    {
        $existingProduct = Products::findOne(['product_name' => $model->product_name]);
        if ($existingProduct !== null) {
            $model->addError('product_name', 'Product already exist!');
            return false;
        }

        return true;
    }

    public function actionUpdate($id)
    {
        date_default_timezone_set('Asia/Manila');
        $model = $this->findProductsModel($id);
        $update_productsModel = new InventoryUpdates();

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->new_stock_quantity) && empty($model->fk_item_status)) {
                Yii::$app->session->setFlash('success', [
                    'title' => 'Yay',
                    'body' => 'Update saved successfully.',
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            } elseif (empty($model->new_stock_quantity)) {
                $model->addError('new_stock_quantity', 'Quantity cannot be empty.');
            } elseif (empty($model->fk_item_status)) {
                $model->addError('fk_item_status', 'Status cannot be empty.');
            } else {
                if ($model->validate()) {
                    if ($model->fk_item_status == 1) {
                        $model->stock_quantity += intval($model->new_stock_quantity);
                        Yii::$app->session->setFlash('success', [
                            'title' => 'Yay',
                            'body' => 'Added ' . $model->new_stock_quantity . ' to the stock quantity',
                        ]);
                    } else {
                        $model->stock_quantity -= intval($model->new_stock_quantity);
                        Yii::$app->session->setFlash('success', [
                            'title' => 'Yay',
                            'body' => 'Decreased ' . $model->new_stock_quantity . ' from the stock quantity',
                        ]);
                    }
                    $update_productsModel->fk_id_item = $model->id;
                    $update_productsModel->fk_id_sub_item = null;
                    $update_productsModel->fk_item_status = $model->fk_item_status;
                    $update_productsModel->quantity = $model->new_stock_quantity;
                    $update_productsModel->updated_by = Yii::$app->user->identity->username;
                    $update_productsModel->updated_time = date('Y-m-d H:i:s');

                    if ($model->save() && $update_productsModel->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        Yii::$app->session->setFlash('error', [
                            'title' => 'Oh no!',
                            'body' => 'Failed to update product.',
                        ]);
                    }
                }
            }
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

    public function actionSubItemsCreate($id)
    {
        $modelSubProducts = new SubProducts();
        $modelProducts = $this->findProductsModel($id);

        $modelHasSub = SubProducts::find()
            ->where(['product_id' => $id])
            ->one();

        if ($modelSubProducts->load(Yii::$app->request->post())) {
            if ($this->validateSubItems($modelSubProducts)){
                if ($modelSubProducts->save()) {
                    if (empty($modelHasSub)) {
                        $modelProducts->stock_quantity = intval($modelSubProducts->quantity);
                    } else {
                        $modelProducts->stock_quantity = intval($modelProducts->stock_quantity) + intval($modelSubProducts->quantity);
                    }
                    $modelProducts->save();
                    return $this->redirect(['view', 'id' => $modelProducts->id]);
                }
            }
        }

        return $this->render('createsub', [
            'model' => $modelSubProducts,
            'productmodel' => $modelProducts,
        ]);
    }

    public function validateSubItems($modelSubProducts)
    {
        $existingProduct = SubProducts::findOne(['sub_products_name' => $modelSubProducts->sub_products_name]);
        if ($existingProduct !== null) {
            $modelSubProducts->addError('sub_products_name', 'Sub Item already exist!');
            return false;
        }
        return true;
    }

    public function actionSubItemsUpdate($id)
    {
        $model = $this->findSubItemsModel($id);
        $modelProducts = $this->findProductsModel($model->product_id);

        if ($model->load(Yii::$app->request->post())) {
            if (empty($model->fk_item_status) && empty($model->new_stock_quantity)) {
                Yii::$app->session->setFlash('success', [
                    'title' => 'Yay',
                    'body' => 'Update saved successfully',
                ]);
                return $this->redirect(['view', 'id' => $modelProducts->id]);
            }

            if (empty($model->fk_item_status)) {
                $model->addError('fk_item_status', 'Status cannot be empty.');
            }

            if (empty($model->new_stock_quantity)) {
                $model->addError('new_stock_quantity', 'Quantity cannot be empty.');
            }

            if ($model->hasErrors()) {
                return $this->render('updatesub', ['model' => $model]);
            }

            $quantityChange = intval($model->new_stock_quantity);
            if ($model->fk_item_status == 1) {
                $model->quantity += $quantityChange;
                $modelProducts->stock_quantity += $quantityChange;
                $flashMessage = 'Added ' . $quantityChange . ' to the sub-item quantity for ' . $model->sub_products_name;
            } else {
                if ($model->quantity >= $quantityChange) {
                    $model->quantity -= $quantityChange;
                    $modelProducts->stock_quantity -= $quantityChange;
                    $flashMessage = 'Decreased ' . $quantityChange . ' from the sub-item quantity for ' . $model->sub_products_name;
                } else {
                    Yii::$app->session->setFlash('error', [
                        'title' => 'Oh no!',
                        'body' => 'The requested quantity cannot be decreased. Current quantity is too low for ' . $model->sub_products_name,
                    ]);
                    return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);
                }
            }

            Yii::$app->session->setFlash('success', [
                'title' => 'Yay',
                'body' => $flashMessage,
            ]);

            $update_productsModel = new InventoryUpdates();
            $update_productsModel->fk_id_item = $modelProducts->id;
            $update_productsModel->fk_id_sub_item = $model->id;
            $update_productsModel->fk_item_status = $model->fk_item_status;
            $update_productsModel->quantity = $model->new_stock_quantity;
            $update_productsModel->updated_by = Yii::$app->user->identity->username;
            $update_productsModel->updated_time = date('Y-m-d H:i:s');

            if ($model->save() && $update_productsModel->save() && $modelProducts->save()) {
                return $this->redirect(['view', 'id' => $modelProducts->id]);
            } else {
                Yii::$app->session->setFlash('error', [
                    'title' => 'Oh no!',
                    'body' => 'Failed to update product.',
                ]);
            }
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
    protected function findSubItemsModel($id)
    {
        if (($model = SubProducts::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
