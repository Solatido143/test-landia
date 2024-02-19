<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use app\resource\EmployeesApi;
use yii\rest\ActiveController;

class EmployeesApiController extends ActiveController
{
    public $modelClass = EmployeesApi::class;

//    public function actionGetdata(){
//        $model = EmployeesApi::find()
//            ->select('id, fname, lname')
//            ->asArray()
//            ->all();
//
//        return (json::encode($model));
//    }

}