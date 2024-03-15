<?php

/* @var $this yii\web\View */
/* @var $paymentModel app\models\Payments */
/* @var $dataProvider app\models\BookingsServices */

$this->title = 'Payments';
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
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
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>

