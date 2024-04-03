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
                        <div class="col-md-6">
                            <?= Html::a('<i class="fas fa-plus"></i>&nbspCreate Products', ['create'], ['class' => 'btn btn-success text-nowrap']) ?>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0">
                            <?= $this->render('_search', ['model' => $searchModel]); ?>
                        </div>
                    </div>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                        'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                        'columns' => [
                            [
                                'class' => DropDownActionColumn::className(),
                                'header' => 'Actions',
                                'contentOptions' => ['style' => 'white-space: nowrap;'],
                                'items' => [
                                    [
                                        'label' => '<i class="fas fa-eye"></i>&nbsp; View',
                                        'url' => ['view']
                                    ],
                                    [
                                        'label' => '<i class="fas fa-pencil"></i>&nbsp; Edit',
                                        'url' => ['update']
                                    ],
                                    [
                                        'label' => '<i class="fas fa-trash"></i>&nbsp; Delete',
                                        'url' => ['delete'],
                                        'linkOptions' => [
                                            'class' => 'dropdown-item contextDelete',
                                            'data-method' => 'post',
                                        ],
                                        'visible' => true,
                                    ]
                                ],
                            ],
                            'product_name',
                            [
                                'attribute' => 'description',
                                'format' => 'ntext',
                                'value' => function ($model) {
                                    $maxWords = 10; // Adjust the number of words as needed
                                    $words = preg_split('/\s+/', $model->description, $maxWords + 1);
                                    if (count($words) > $maxWords) {
                                        array_pop($words);
                                        $truncatedDescription = implode(' ', $words) . '...'; // Adding ellipsis to indicate truncation
                                        return $truncatedDescription;
                                    } else {
                                        return $model->description;
                                    }
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
