<?php

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $services app\models\Services */
/* @var $servicesModel app\models\Services */

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
                        'services' => $services,
                        'servicesModel' => $servicesModel,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>