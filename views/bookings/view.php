<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */

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
                                    <?= Html::a('<i class="fa fa-cancel"></i>&nbspCancel', ['cancel', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
                                    <?= Html::a('<i class="fa fa-pencil"></i>&nbsp;Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                <?php else : ?>
                                    <?= Html::a('<i class="fa fa-arrow-left"></i>&nbspBack', ['index'], ['class' => 'btn btn-secondary']) ?>
                                <?php endif; ?>

                            </p>
                        </div>
                        <div>
                            <p>
                                <?php if ($model->fk_booking_status == 1) : ?>
                                    <?= Html::a('<i class="fa fa-forward-step"></i>&nbsp; Set as Ongoing', ['ongoing', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?php elseif ($model->fk_booking_status == 2) : ?>
                                    <?= Html::a('<i class="fa fa-check"></i>&nbsp; Set as Complete', ['complete', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
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
                                    'logged_by',
                                    'logged_time',
                                    'updated_by',
                                    'updated_time',
                                ],
                            ]) ?>
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