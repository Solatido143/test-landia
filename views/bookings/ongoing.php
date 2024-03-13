<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $bookingModel app\models\Bookings */
/* @var $employeeSelectionModel app\models\EmployeeSelectionForm */

$this->title = 'Select Employee';
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $bookingModel->fkBookingStatus->booking_status. ' ' .$bookingModel->fkCustomer->customer_name. ' ' .$bookingModel->booking_type, 'url' => ['view', 'id' => $bookingModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_formSelectEmployee', [
                        'model' => $employeeSelectionModel,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>
