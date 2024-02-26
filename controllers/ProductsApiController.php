<?php

namespace app\controllers;

use app\models\Products;
use app\models\SubProducts;
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

        $products = Products::find()->with('subProducts')->all();

        // Prepare an array to hold the formatted product data
        $formattedProducts = [];

        // Loop through each product
        foreach ($products as $product) {
            // Create an array to hold the product data
            $formattedProduct = $this->getFormattedProduct($product);

            // Add the formatted product to the array of formatted products
            $formattedProducts[] = $formattedProduct;
        }

        return $formattedProducts;
    }

    /**
     * Formats a product along with its subproducts.
     *
     * @param Products $product The product model instance
     * @return array The formatted product data
     */
    private function getFormattedProduct($product)
    {
        $formattedProduct = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'stock_quantity' => $product->stock_quantity,
        ];

        // Check if 'expand' parameter is provided and set to 'subProducts'
        $expandSubProducts = Yii::$app->request->get('expand') === 'subproducts';

        // Include subproducts if 'expand' parameter is provided and set to 'subProducts'
        if ($expandSubProducts) {
            $formattedProduct['subProducts'] = NULL;
            foreach ($product->subProducts as $subProduct) {
                $formattedProduct['subProducts'][] = [
                    'id' => $subProduct->id,
                    'name' => $subProduct->name,
                    'description' => $subProduct->description,
                    'quantity' => $subProduct->quantity,
                ];
            }
        }

        return $formattedProduct;
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

    // Custom action to Create Sub Products
    public function actionCreateSubProducts()
    {
        $model = new SubProducts();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($model->save()) {
            Yii::$app->response->setStatusCode(201); // Created
            return $model;
        } else {
            return ['errors' => $model->errors];
        }
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

    public function actionUpdateSubProducts($id = null)
    {
        Yii::$app->getResponse()->format = Response::FORMAT_JSON;

        if ($id === null) {
            return [
                'success' => false,
                'error' => 'Missing parameter',
                'message' => 'The required parameter id is missing.'
            ];
        }

        $model = SubProducts::findOne($id);
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

    // Custom action to view a single product
    public function actionViewProducts($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Check if $id is provided
        if ($id === null) {
            return [
                'success' => false,
                'name' => 'Bad Request',
                'message' => 'Missing required parameter: id'
            ];
        }

        // Find the product by $id
        $product = Products::findOne($id);

        // Check if the product is found
        if ($product === null) {
            return [
                'isProductExist' => false,
                'name' => 'Not Found',
                'message' => 'Product not found.'
            ];
        }

        // Prepare an array to hold the formatted product data
        $formattedProduct = $this->getFormattedProduct($product);

        return $formattedProduct;
    }

    // Custom action to view a single product
    public function actionViewSubProducts($id = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Check if $id is provided
        if ($id === null) {
            return [
                'success' => false,
                'name' => 'Bad Request',
                'message' => 'Missing required parameter: id'
            ];
        }

        // Find the product by $id
        $subproduct = SubProducts::findOne($id);

        // Check if the product is found
        if ($subproduct === null) {
            return [
                'isProductExist' => false,
                'name' => 'Not Found',
                'message' => 'Product not found.'
            ];
        }

        // Prepare an array to hold the formatted product data
        $formattedProduct = $this->getFormattedSubProduct($subproduct);

        return $formattedProduct;
    }

    public function actionGetSubProducts()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $subProducts = SubProducts::find()->with('products')->all();

        // Prepare an array to hold the formatted sub-product data
        $formattedSubProducts = [];

        // Loop through each sub-product
        foreach ($subProducts as $subProduct) {
            // Prepare an array to hold the formatted sub-product data
            $formattedSubProduct = $this->getFormattedSubProduct($subProduct);

            // Add the formatted sub-product to the array of formatted products
            $formattedSubProducts[] = $formattedSubProduct;
        }

        return $formattedSubProducts;
    }

    /**
     * Formats a subproduct along with its product.
     *
     * @param SubProducts $subProduct The subproduct model instance
     * @return array The formatted subproduct data
     */
    private function getFormattedSubProduct($subProduct)
    {
        $formattedSubProduct = [
            'id' => $subProduct->id,
            'name' => $subProduct->name,
            'description' => $subProduct->description,
            'stock_quantity' => $subProduct->quantity,
        ];

        // Check if 'expand' parameter is provided and set to 'product'
        $expandProduct = Yii::$app->request->get('expand') === 'product';

        // Include main product by default
        $formattedSubProduct['main_product'] = $expandProduct ? $subProduct->products->name : null;

        // If 'expand' parameter is not provided or not set to 'product', hide main product
        if (!$expandProduct) {
            unset($formattedSubProduct['main_product']);
        }

        return $formattedSubProduct;
    }
}
