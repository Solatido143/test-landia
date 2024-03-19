<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $bookingServices app\models\BookingsServices */
/* @var $bookingsTimingModel app\models\BookingsTiming */

$this->title = $model->fkBookingStatus->booking_status . ' ' . $model->fkCustomer->customer_name . ' ' . $model->booking_type;
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between">
                        <div>
                            <p>

                                <?php if ($model->fk_booking_status != 4 && $model->fk_booking_status != 3) : ?>
                                    <?= Html::a('<i class="fa fa-cancel"></i>&nbsp;Cancel', ['cancel', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
                                    <?= Html::a('<i class="fa fa-pencil"></i>&nbsp;Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                <?php else : ?>
                                    <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp;Back', ['index'], ['class' => 'btn btn-secondary']) ?>
                                <?php endif; ?>

                            </p>
                        </div>
                        <div>
                            <p>
                                <?php if ($model->fk_booking_status == 1) : ?>
                                    <?= Html::a('<i class="fa fa-forward-step"></i>&nbsp; Set as Ongoing', ['ongoing', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?php elseif ($model->fk_booking_status == 2) : ?>
                                    <?= Html::a('<i class="fa fa-cash-register"></i>&nbsp; Set as Complete', ['payments', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'booking_type',
                                    [
                                        'attribute' => 'fk_customer',
                                        'label' => 'Customer Name',
                                        'value' => function ($model) {
                                            return $model->fkCustomer->customer_name;
                                        },
                                    ],
                                    [
                                        'attribute' => 'fk_booking_status',
                                        'label' => 'Booking Status',
                                        'value' => function ($model) {
                                            return $model->fkBookingStatus->booking_status;
                                        },
                                    ],
                                    'schedule_time',
                                    'remarks:ntext',
                                ],
                            ]) ?>

                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'logged_by',
                                    'logged_time',
                                    'updated_by',
                                    'updated_time',
                                ],
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?php if ($bookingsTimingModel !== null): ?>

                                <?= DetailView::widget([
                                    'model' => $bookingsTimingModel,
                                    'attributes' => [
                                        [
                                            'attribute' => 'fk_employee',
                                            'label' => 'Assigned Employee',
                                            'value' => function ($bookingsTimingModel) {
                                                return $bookingsTimingModel->fkEmployee->fname . ' ' . $bookingsTimingModel->fkEmployee->lname;
                                            },
                                        ]
                                    ],
                                ]) ?>

                            <?php elseif ($model->fk_booking_status != 3) :?>

                                <div class="col-md-12">
                                    <?= \yii\grid\GridView::widget([
                                        'dataProvider' => $bookingServices,
                                        'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                        'tableOptions' => ["class" => "table table-striped table-bordered"],
                                        'layout' => "{items}\n{pager}",
                                        'columns' => [
                                            [
                                                'attribute' => 'fk_service',
                                                'label' => 'Service Name',
                                                'value' => function ($model) {
                                                    // Access the related Service model
                                                    $service = $model->fkService;
                                                    // Check if the service exists
                                                    if ($service !== null) {
                                                        // Return the service name
                                                        return $service->service_name;
                                                    } else {
                                                        return null; // or any default value
                                                    }
                                                },
                                            ],
                                            [
                                                'attribute' => 'fk_service',
                                                'label' => 'Service Fee',
                                                'value' => function ($model) {
                                                    // Access the related Service model
                                                    $service = $model->fkService;
                                                    // Check if the service exists
                                                    if ($service !== null) {
                                                        // Return the service fee
                                                        return '₱' . $service->service_fee;
                                                    } else {
                                                        return null; // or any default value
                                                    }
                                                },
                                            ],
                                        ],
                                        'pager' => [
                                            'class' => 'yii\bootstrap4\LinkPager',
                                        ]
                                    ]);?>
                                </div>

                                <?php if ($model->fk_booking_status != 2) :?>
                                    <div class="col-md-12">
                                        <div class="d-flex justify-content-center align-items-center h-100">
                                            <h1>
                                                Queue Time: <span> 0 </span><span>mins</span>
                                            </h1>
                                        </div>
                                    </div>
                                <?php endif; ?>


                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>