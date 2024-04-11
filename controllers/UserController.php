<?php
namespace app\controllers;

use app\models\RegisterForm;
use app\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public function actionGetUsers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Fetch query parameters
        $queryParams = Yii::$app->request->queryParams;

        // Check if expand parameter is set
        $expandFields = [];
        if (isset($queryParams['expand'])) {
            $expandFields = explode(',', $queryParams['expand']);
            unset($queryParams['expand']);
        }

        // Initialize the query with the User model
        $query = User::find()->select(['id', 'username', 'fk_employee_id', 'email', 'user_access']);

        // Include expanded fields in the query
        foreach ($expandFields as $field) {
            $query->addSelect($field);
        }

        // Apply conditions based on query parameters
        foreach ($queryParams as $attribute => $value) {
            $query->andWhere([$attribute => $value]);
        }

        // Execute the query to fetch users
        $users = $query->all();

        return $users;
    }
    public function actionViewUsers($queryParams)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Check if there are any query parameters
        if (empty($queryParams)) {
            return [
                'error' => true,
                'message' => 'No query parameters provided.'
            ];
        }
        // Initialize the query with the User model
        $query = User::find();
        // Select only the required fields
        $query->select(['id', 'username', 'fk_employee_id', 'email', 'user_access']);

        // Apply conditions based on query parameters
        foreach ($queryParams as $attribute => $value) {
            $query->andWhere([$attribute => $value]);
        }

        // Execute the query to fetch a single user
        $user = $query->one();

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

    public function actionValidateLogin($username, $password)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Find the user by username
        $user = User::findOne(['username' => $username]);
        if ($user !== null) {
            // Validate the password
            if (Yii::$app->security->validatePassword($password, $user->password_hash)) {
                // Password is correct
                return [
                    'success' => true,
                    'id' => $user->id,
                ];
            }
        }

        // Either username or password is incorrect
        return ['success' => false];
    }
}
