<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $dataProvider app\models\Services */

$this->title = 'New Bookings';
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'dataProvider' => $dataProvider,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>
