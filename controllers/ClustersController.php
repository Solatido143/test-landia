<?php

namespace app\controllers;

use Yii;
use app\resource\Clusters;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class ClustersController extends ActiveController
{
    public $modelClass = Clusters::class;
}