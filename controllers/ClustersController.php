<?php

namespace app\controllers;

use app\resource\Clusters;
use yii\rest\ActiveController;

class ClustersController extends ActiveController
{
    public $modelClass = Clusters::class;

}