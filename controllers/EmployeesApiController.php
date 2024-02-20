<?php

namespace app\controllers;

use Yii;
use app\resource\EmployeesApi;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class EmployeesApiController extends ActiveController
{
    public $modelClass = EmployeesApi::class;
}
