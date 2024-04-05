<?php

namespace app\models;

use yii\base\Model;
use yii\validators\UniqueValidator;

class CustomerRegisterForm extends Model
{
    public $confirmPassword;

    public function rules()
    {
        return [
            [['username', 'password', 'email', 'confirmPassword'], 'required'],
            ['username', 'string', 'min' => 3, 'max' => 255],
            ['password', 'string', 'min' => 3],
            ['email', 'email'],
            ['confirmPassword', 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match.'],
            ['username', UniqueValidator::class, 'targetClass' => User::class, 'message' => 'This username has already been taken.'],
        ];
    }
}