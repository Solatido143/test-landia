<?php

namespace app\models;

use yii\base\Model;

class SelectEmployeeForm extends Model
{
    public $select_Employee;

    public function rules()
    {
        return [
            [['select_Employee'], 'required'],
        ];
    }
}