<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\validators\UniqueValidator;

class RegisterForm extends Model
{
    public $email;
    public $username;
    public $password;
    public $confirmPassword;
    public $emp_id;

    public function rules()
    {
        return [
            [['username', 'password', 'email', 'confirmPassword', 'emp_id'], 'required'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['password', 'string', 'min' => 3],
            ['email', 'email'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
            ['username', UniqueValidator::class, 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            ['emp_id', 'validateEmployeeId'],
        ];
    }

    public function validateEmployeeId($attribute, $params)
    {
        $employee = Employees::findOne(['employee_id' => $this->$attribute]);
        if ($employee === null) {
            Yii::$app->session->setFlash('error', [
                'title' => 'Oh no!',
                'body' => 'Something went wrong, please try again.',
            ]);
        }
    }

    public function register()
    {
        if ($this->validate()) {

            $existingUser = User::findOne(['fk_employee_id' => $this->emp_id]);
            if ($existingUser !== null) {
                Yii::$app->session->setFlash('error', [
                    'title' => 'Oh no!',
                    'body' => 'Something went wrong, please try again.',
                ]);
                return false;
            }

            $employee = Employees::findOne(['employee_id' => $this->emp_id]);
            if ($employee === null) {
                Yii::$app->session->setFlash('error', [
                    'title' => 'Oh no!',
                    'body' => 'Something went wrong, please try again.',
                ]);
                return false;
            }

            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->verification_token = Yii::$app->security->generateRandomString();
            $user->fk_employee_id = $employee->employee_id;
            $user->password_reset_token = NUll;
            $user->user_access = 6;
            $user->status = 10;
            $user->created_at = date('Y-m-d H:i:s');

            if ($user->save()) {
                return true;
            } else {
                Yii::$app->session->setFlash('error', [
                    'title' => 'Oh no!',
                    'body' => 'You do not have permission to delete this item.',
                ]);
                return false;
            }
        }

        return false;
    }
}
