<?php
namespace app\controllers;

use app\models\RegisterForm;
use app\models\User;
use app\models\LoginForm;

use Yii;

use yii\rest\ActiveController;

use yii\web\NotFoundHttpException;
use yii\web\Response;

class UserController extends ActiveController
{
    public $modelClass = 'app\models\User';

    public function actions()
    {
        $actions = parent::actions();

        // Disable default CRUD actions
        unset($actions['index'], $actions['create'], $actions['view'], $actions['update'], $actions['delete']);

        return $actions;
    }

    // Custom action to retrieve all users
    public function actionGetUsers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $users = User::find()->all();
        return $users;
    }

    // Custom action to create a new user
    public function actionCreateUsers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = new RegisterForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->validate()) {
            if ($model->register()) {
                Yii::$app->getResponse()->setStatusCode(201); // Created
                Yii::$app->getResponse()->format = Response::FORMAT_JSON;
                return $model;
            } else {
                Yii::$app->getResponse()->setStatusCode(500); // Internal Server Error
                return ['error' => 'Failed to register user.', 'success' => false];
            }
        } else {
            $errors = $model->errors;
            if (isset($errors['username']) && strpos($errors['username'][0], 'This username has already been taken.') !== false) {
                Yii::$app->getResponse()->setStatusCode(400); // Bad request
                return ['error' => 'Username already exists.', 'success' => false];
            } elseif (isset($errors['email']) && strpos($errors['email'][0], 'is not a valid email address.') !== false) {
                Yii::$app->getResponse()->setStatusCode(400); // Bad request
                return ['error' => 'Invalid email address.', 'success' => false];
            } else {
                Yii::$app->getResponse()->setStatusCode(422); // Unprocessable Entity
                return ['errors' => $errors];
            }
        }
    }


    // Custom action to view a single user
    public function actionViewUsers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Fetch query parameters
        $queryParams = Yii::$app->request->queryParams;

        // Check if there are any query parameters
        if (empty($queryParams)) {
            return [
                'error' => true,
                'message' => 'No query parameters provided.'
            ];
        }

        // Initialize the query with the User model
        $query = User::find();

        // Apply conditions based on query parameters
        foreach ($queryParams as $attribute => $value) {
            $query->andWhere([$attribute => $value]);
        }

        // Execute the query
        $user = $query->all();

        // Check if user is found
        if ($user === null) {
            return [
                'isUserExist' => false,
                'name' => 'Not found',
                'message' => 'User not found.'
            ];
        }

        return $user;
    }

    // Custom action to update a user
    public function actionUpdateUsers($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = User::findOne($id);
        if ($model === null) {
            return [
                'isUserExist' => false,
                'name' => 'Not found',
                'message' => 'User not found.'
            ];
        }

        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save()) {
            return $model;
        } else {
            return ['errors' => $model->errors];
        }
    }

    // Custom action to delete a user
    public function actionDeleteUsers($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $model = User::findOne($id);
        if ($model === null) {
            return [
                'isUserExist' => false,
                'name' => 'Not found',
                'message' => 'User not found.'
            ];
        }
        $model->delete();
        Yii::$app->getResponse()->setStatusCode(204); // No content
    }

    public function actionValidateLogin($username, $password)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Find the user by username
        $user = User::findOne(['username' => $username]);
        if ($user !== null) {
            // Validate the password
            if (Yii::$app->security->validatePassword($password, $user->password_hash)) {
                // Password is correct
                return ['success' => true];
            }
        }

        // Either username or password is incorrect
        return ['success' => false];
    }
}