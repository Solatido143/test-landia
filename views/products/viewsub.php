<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\SubProducts */
/* @var $productmodel app\models\Products */


$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => isset($model->product_id) ? \app\models\Products::findOne($model->product_id)->name : '',
    'url' => ['view', 'id' => $model->product_id],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <p>
                                <?= Html::a('Update', ['sub-items-update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Delete', ['sub-items-delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </p>
                            <?= DetailView::widget([
                                'model' => $model,
                                'options' => ['class' => 'table table-striped table-bordered'], // Optional: Add a responsive class to the table
                                'attributes' => [
                                    'id',
                                    [
                                        'attribute' => 'product_id',
                                        'label' => 'Main Product',
                                        'value' => function ($model) {
                                            return isset($model->product_id) ? \app\models\Products::findOne($model->product_id)->name : null;
                                        },
                                    ],
                                    'name',
                                    'description',
                                    'quantity',
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
    </div>

</div>