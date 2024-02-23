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
        $model = new RegisterForm();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if ($model->register()) {
            Yii::$app->getResponse()->setStatusCode(201); // Created
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return $model;
        } else {
            Yii::$app->getResponse()->format = Response::FORMAT_JSON;
            return ['errors' => $model->errors];
        }
    }

    // Custom action to view a single user
    public function actionViewUsers($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user = User::findOne($id);
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
