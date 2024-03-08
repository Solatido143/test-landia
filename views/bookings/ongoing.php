<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */

$this->title = 'Select Employee';
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fkBookingStatus->booking_status. ' ' .$model->fkCustomer->customer_name. ' ' .$model->booking_type, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_formSelectEmployee', [
                        'model' => $model,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>
