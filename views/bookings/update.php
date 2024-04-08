<?php

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $dataProvider app\models\Services */

$this->title = 'Update Bookings: ' . $model->fkCustomer->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->fkBookingStatus->booking_status . ' ' . $model->fkCustomer->customer_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
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