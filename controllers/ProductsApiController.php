<?php

namespace app\controllers;

use app\models\Products;
use Yii;
use yii\web\Response;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class ProductsApiController extends ActiveController
{
    public $modelClass = 'app\models\Products';

    public function actions()
    {
        $actions = parent::actions();

        // Disable default CRUD actions
        unset($actions['index'], $actions['create'], $actions['view'], $actions['update'], $actions['delete']);

        return $actions;
    }

    // Custom action to retrieve all products
    public function actionGetProducts()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $products = Products::find()->all();
        return $products;
    }

    // Custom action to create a new product
    public function actionCreateProducts()
    {
        $model = new Products();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return $model;
        } else {
            return ['errors' => $model->errors];
        }
    }

    // Custom action to view a single product
    public function actionViewProducts($id)
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        $product = Products::findOne($id);
        if ($product === null) {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return [
                'isUserExist' => false,
                'name' => 'Not found',
                'message' => 'Product not found.'
            ];
        }
        return $product;
    }

    // Custom action to update a product
    public function actionUpdateProducts($id = null)
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if ($id === null) {
            return [
                'success' => false,
                'error' => 'Missing parameter',
                'message' => 'The required parameter id is missing.'
            ];
        }

        $model = Products::findOne($id);
        if ($model === null) {
            return [
                'success' => false,
                'error' => 'Product not found',
                'message' => 'Product not found for the given ID.'
            ];
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        } else {
            return [
                'success' => false,
                'errors' => $model->errors,
                'message' => 'Failed to update product.'
            ];
        }
    }

    // Custom action to delete a product
    public function actionDeleteProducts($id)
    {
        $model = Products::findOne($id);
        if ($model === null) {
            return [
                'isUserExist' => false,
                'name' => 'Not found',
                'message' => 'Product not found.'
            ];
        }
        $model->delete();
        Yii::$app->response->setStatusCode(204); // No content
    }
}
