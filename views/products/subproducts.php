<?php

use microinginer\dropDownActionColumn\DropDownActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\SubProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Sub Items';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?= Html::a('<i class="fas fa-plus"></i> Create Sub Items', ['sub-items-create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>

                    <?= GridView::widget([
                        'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                        'columns' => [
                            [
                                'class' => DropDownActionColumn::className(),
                                'header' => 'Actions',
                                'contentOptions' => ['style' => 'white-space: nowrap;'],
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
                            [
                                'attribute' => 'sub_product_id',
                                'label' => 'Main Product',
                                'value' => function ($model) {
                                    return isset($model->sub_product_id) ? \app\models\Products::findOne($model->sub_product_id)->name : null;
                                },
                            ],
                            'name',
                            'description',
                            'quantity',
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ]
                    ]); ?>

                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
