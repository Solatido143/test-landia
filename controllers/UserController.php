<?php

namespace app\controllers;

use app\models\User;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;

class UserController extends Controller
{
    public function actionUserAccounts()
    {
        $model = User::find()->asArray()->all();
        return json::encode($model);
    }

    public function actionCreate()
    {
        $request = Yii::$app->request;
        $user = new User();

        if ($request->isPost) {
            $user->load($request->post());

            if ($user->save()) {
                return $this->asJson(['success' => true, 'message' => 'User created successfully']);
            } else {
                return $this->asJson(['success' => false, 'errors' => $user->errors]);
            }
        }

        return $this->asJson(['success' => false, 'message' => 'Bawal ka pumasok Jerick']);
    }

}