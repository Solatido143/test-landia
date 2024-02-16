<?php

namespace app\models;

use yii\base\Model;
use Yii;
use yii\helpers\VarDumper;
use yii\validators\UniqueValidator; // Import the UniqueValidator class

class RegisterForm extends Model
{
    public $username;
    public $new_password;
    public $password;
    public $confirm_password;

    public function rules()
    {
        return [
            [['username', 'new_password'], 'required'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['new_password', 'string', 'min' => 8],
            ['confirm_password', 'compare', 'compareAttribute' => 'new_password', 'message' => 'Passwords do not match.'],
            ['username', UniqueValidator::class, 'targetClass' => User::class, 'message' => 'This username has already been taken.'], // Add the unique validator for username
        ];
    }
    public function register()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
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
