<?php

namespace app\models;

use yii\base\Model;

class PasswordResetRequestForm extends Model
{
    public $reset_password;
    public $email;
}