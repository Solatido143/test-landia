<?php

use microinginer\dropDownActionColumn\DropDownActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\Services */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model app\models\Services */


$this->title = 'Services';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-8">
                            <?php
                            $query = \app\models\Services::find();
                            $dataProvider = new yii\data\ActiveDataProvider([
                                'query' => $query, // $query should be your ActiveRecord query
                                'pagination' => [
                                    'pageSize' => 5, // Adjust the number of items per page here
                                ],
                            ]);
                            ?>
                            <?= GridView::widget([
                                'dataProvider' => $dataProvider,
                                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                'layout' => "{items}\n{pager}",
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
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

                                    'service_name',
                                    'service_fee',
                                    [
                                        'attribute' => 'completion_time',
                                        'value' => function ($model) {
                                            return $model->completion_time . ' mins';
                                        }
                                    ],
                                ],
                                'summaryOptions' => ['class' => 'summary mb-2'],
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ],
                            ]); ?>
                        </div>
                        <div class="col-md-4 text-end">
                            <?= Html::a('<i class="fas fa-plus"></i>&nbspAdd services', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>

                    </div>

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
