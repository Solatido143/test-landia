<?php

namespace app\controllers;

use app\models\User;
use yii\helpers\Json;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionLogin()
    {
        $model = User::find()->asArray()->all();
        return json::encode($model);
    }

}