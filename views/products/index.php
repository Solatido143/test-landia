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
                        <div class="col-md-12">
                            <?= Html::a('Create Products', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>


<!--                    --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
//                        'filterModel' => $searchModel,
                        'columns' => [
//                            ['class' => 'yii\grid\SerialColumn'],

                            'product_id',
                            'name',
                            'description:ntext',
                            'price',
                            'stock_quantity',
                            [
                                'header' => 'Actions',
                                'content' => function ($model) {
                                    $viewButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-eye']), ['products/view', 'product_id' => $model->product_id], ['class' => 'btn btn-primary py-0']);
                                    $updateButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-pencil']), ['products/update', 'product_id' => $model->product_id], ['class' => 'btn btn-warning py-0']);

                                    return $viewButton . ' ' . $updateButton;
                                },
                            ],

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
