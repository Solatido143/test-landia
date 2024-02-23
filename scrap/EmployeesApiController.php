<?php

namespace app\models;

use app\resource\EmployeesApi;
use yii\rest\ActiveController;

class EmployeesApiController extends ActiveController
{
    public $modelClass = EmployeesApi::class;
}
