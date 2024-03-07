<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */

$this->title = $model->id;
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
                                <?= Html::a('<i class="fa fa-cancel"></i>&nbspCancel', ['cancel'], ['class' => 'btn btn-danger']) ?>
                                <?= Html::a('<i class="fa fa-pencil"></i>&nbspUpdate', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                            </p>
                        </div>
                        <div>
                            <p>
                                <?= Html::a('<i class="fa fa-forward-step"></i>&nbspSet as Ongoing', ['ongoing', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                            </p>
                        </div>
                    </div>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'booking_type',
                            'fk_customer',
                            'fk_booking_status',
                            'schedule_time',
                            'remarks:ntext',
                            'logged_by',
                            'logged_time',
                            'updated_by',
                            'updated_time',
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>