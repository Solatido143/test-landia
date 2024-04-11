<?php

use microinginer\dropDownActionColumn\DropDownActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\CustomersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Customers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <?= Html::a('Create Customer', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?= $this->render('_search', ['model' => $searchModel]); ?>
                        </div>
                    </div>

                    <?= GridView::widget([
                        'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                        'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            //['class' => 'yii\grid\SerialColumn'],
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

                            'customer_name',
                            'contact_number',
                            'logged_by',
                            'logged_time',
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
