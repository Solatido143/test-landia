<?php

use microinginer\dropDownActionColumn\DropDownActionColumn;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">


                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                            <?php if (!$model->isRemove): ?>
                                                <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                                                    'class' => 'btn btn-danger',
                                                    'data' => [
                                                        'confirm' => 'Are you sure you want to delete this item?',
                                                        'method' => 'post',
                                                    ],
                                                ]) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            'id',
                                            'name',
                                            'description:ntext',
                                            'stock_quantity',
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
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex justify-content-between">
                                <h4 class="mb-0 me-2">Sub Items</h4>
                                <div class="text-end">
                                    <?= Html::a('<i class="fas fa-eye"></i> View all', ['sub-items'], ['class' => 'btn btn-success']) ?>
                                    <?= Html::a('<i class="fas fa-plus"></i> Add sub-product', ['sub-products/create', 'id' => $model->id], ['class' => 'btn btn-outline-success']) ?>
                                </div>
                            </div>
                            <?= GridView::widget([
                                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                'dataProvider' => new \yii\data\ActiveDataProvider([

                                    'query' => $model->getSubProducts(),
                                    'pagination' => [
                                        'pageSize' => 10,
                                    ],
                                ]),
                                'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],

                                'columns' => [
                                    [
                                        'class' => DropDownActionColumn::className(),
                                        'header' => 'Actions',
                                        'contentOptions' => ['style' => 'white-space: nowrap; width: 10%;'],
                                        'items' => [
                                            [
                                                'label' => 'Views',
                                                'url' => ['sub-items']
                                            ],
                                            [
                                                'label' => 'Edit',
                                                'url' => ['sub-items-update']
                                            ],
                                            [
                                                'label' => 'Delete',
                                                'url' => ['sub-items-delete'],
                                                'linkOptions' => [
                                                    'class' => 'dropdown-item contextDelete',
                                                    'data-method' => 'post',
                                                ],
                                                'visible' => true,

                                            ]
                                        ],
                                    ],
                                    'id',
                                    'name',
                                    'description',
                                    'quantity',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--card-->
        </div>
    </div>



</div>
