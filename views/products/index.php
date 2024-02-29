<?php

use yii\helpers\Html;
use yii\grid\GridView;
use microinginer\dropDownActionColumn\DropDownActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <?= Html::a('<i class="fas fa-plus"></i>&nbspCreate Products', ['create'], ['class' => 'btn btn-success text-nowrap']) ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?= $this->render('_search', ['model' => $searchModel]); ?>
                        </div>
                    </div>

                    <?php
                    $dataProvider->query->andWhere(['isRemove' => 0]);
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                        'tableOptions' => ["class" => "table table-striped table-bordered"],
                        'columns' => [
                            [
                                'class' => DropDownActionColumn::className(),
                                'header' => 'Actions',
                                'contentOptions' => ['style' => 'white-space: nowrap;'],
                                'items' => [
                                    [
                                        'label' => 'Views',
                                        'url' => ['view']
                                    ],
                                    [
                                        'label' => 'Edit',
                                        'url' => ['update']
                                    ],
                                    [
                                        'label' => 'Delete',
                                        'url' => ['delete'],
                                        'linkOptions' => [
                                            'class' => 'dropdown-item contextDelete',
                                            'data-method' => 'post',
                                            ],
                                        'visible' => true,

                                    ]
                                ],
                            ],
                            'id',
                            'product_name',
                            [
                                'attribute' => 'description',
                                'format' => 'ntext',
                                'value' => function ($model) {
                                    return \yii\helpers\StringHelper::truncate($model->description, 50); // Adjust the number of characters as needed
                                },
                                'contentOptions' => ['style' => 'white-space: nowrap;'],
                            ],
                            [
                                'attribute' => 'stock_quantity',
                                'contentOptions' => ['style' => 'white-space: nowrap;'],
                            ],
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ],
                    ]);?>



                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
