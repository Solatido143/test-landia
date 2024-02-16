<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\VarDumper;
use yii\validators\UniqueValidator; // Import the UniqueValidator class

class RegisterForm extends Model
{
    public $email;
    public $username;
    public $new_password;
    public $password;
    public $confirmPassword;

    public function rules()
    {
        return [
            [['username', 'new_password', 'email', 'confirmPassword'], 'required'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['confirmPassword', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Passwords do not match.'],
            ['username', UniqueValidator::class, 'targetClass' => User::class, 'message' => 'This username has already been taken.'], // Add the unique validator for username
        ];
    }
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password = Yii::$app->security->generatePasswordHash($this->new_password);

            if ($user->save()) {
                return true;
            } else {
                Yii::error("Unsuccessful account creation: " . VarDumper::dumpAsString($user->errors));
            }
        }

        return false;
    }
}
