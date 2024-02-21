<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">

                        <div class="col-auto me-auto">
                            <?= Html::a('Create Products', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>

                        <div class="col-auto">
                            <?= $this->render('_search', ['model' => $searchModel]); ?>
                        </div>

                    </div>



                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
                        'columns' => [
//                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                'header' => 'Actions',
                                'contentOptions' => ['style' => 'white-space: nowrap;'], // Prevent content from wrapping
                                'content' => function ($model) {
                                    $viewButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-eye']), ['products/view', 'product_id' => $model->product_id], ['class' => 'btn btn-primary py-0', 'style' => 'display: inline-block;']);
                                    $updateButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-pencil']), ['products/update', 'product_id' => $model->product_id], ['class' => 'btn btn-warning py-0', 'style' => 'display: inline-block;']);

                                    return $viewButton . ' ' . $updateButton;
                                },
                            ],
                            'product_id',
                            'name',
                            [
                                'attribute' => 'description',
                                'format' => 'ntext',
                                'value' => function ($model) {
                                    return \yii\helpers\StringHelper::truncate($model->description, 50); // Adjust the number of characters as needed
                                },
                            ],

                            'price',
                            'stock_quantity',



//                            ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
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
