<?php

namespace app\models;

use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    public $old_password;
    public $new_password;
    public $user;
    public $confirm_new_password;

    public function rules()
    {
        return [
            [['old_password', 'new_password', 'confirm_new_password'], 'required'],
            ['new_password', 'string', 'min' => 3],
            ['confirm_new_password', 'compare', 'compareAttribute' => 'new_password'],
            ['old_password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params = [])
    {
        if (!$this->hasErrors()) {
            if (!$this->user || !$this->user->validatePassword($this->old_password)) {
                $this->addError($attribute, 'Incorrect old password.');
                return null;
            }
        }
    }


    public function attributeLabels()
    {
        return [
            'old_password' => 'Old Password',
            'new_password' => 'New Password',
            'confirm_new_password' => 'Confirm New Password',
        ];
    }
}
