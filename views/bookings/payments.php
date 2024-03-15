<?php

/* @var $this yii\web\View */
/* @var $paymentModel app\models\Payments */
/* @var $dataProvider app\models\BookingsServices */
/* @var $bookingModel app\models\Bookings */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $bookingModel->fkCustomer->customer_name . ' ' . $bookingModel->booking_type, 'url' => ['view', 'id' => $bookingModel->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_paymentForm', [
                        'paymentModel' => $paymentModel,
                        'dataProvider' => $dataProvider,
                        'bookingModel' => $bookingModel,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>

