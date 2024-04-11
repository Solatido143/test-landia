<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\validators\UniqueValidator;

class CustomerRegisterForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $confirmPassword;
    public $customer_name;
    public $contact_number;

    public function rules()
    {
        return [
            [['username', 'password', 'email', 'customer_name', 'contact_number', 'confirmPassword'], 'required'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['password', 'string', 'min' => 3],
            ['contact_number', 'string', 'max' => 255],
            ['email', 'email'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
            ['username', UniqueValidator::class, 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
            [
                ['contact_number'],
                'match',
                'pattern' => '/^(?:\+639|09)\d{9}$|^\d{3}-\d{4}$|^\d{4}-\d{4}$|^\d{7}$|^\d{8}$|^(\d{4}\s\d{4})$/',
                'message' => 'Please enter a valid contact number',
            ],
        ];
    }

    public function customerRegister()
    {
        date_default_timezone_set('Asia/Manila');

        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);

            $user->password_reset_token = null;
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->verification_token = Yii::$app->security->generateRandomString();

            $user->user_access = 6;
            $user->status = 1;
            $user->created_at = date('Y-m-d H:i:s');

            if ($user->save()) {
                $customer = new Customers();
                $customer->customer_name = $this->customer_name;
                $customer->contact_number = $this->contact_number;
                $customer->logged_time = date('Y-m-d H:i:s');
                $customer->logged_by = 'system';
                $customer->updated_by = '';
                $customer->updated_time = '';
                $customer->fk_user_id = $user->id;

                if ($customer->validate()) {
                    if ($customer->save()) {
                        return true;
                    } else {
                        $user->delete();
                        return false;
                    }
                } else {
                    $user->delete();
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}