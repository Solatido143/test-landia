<?php

use app\models\Positions;
use microinginer\dropDownActionColumn\DropDownActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\EmployeesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Employees';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col col-md-6">
                            <?= Html::a('Create Employees', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                        <div class="col-12 col-sm-6">
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
                            'employee_id',
                            [
                                'attribute' => 'fk_position',
                                'label' => 'Position',
//                                'value' => function ($model) {
//                                    // Fetch the position name based on the fk_position value
//                                    $position = Positions::findOne($model->fk_position);
//                                    return $position ? $position->position : null;
//                                },
                            ],
                            [
                                'attribute' => 'fname',
                                'label' => 'First Name',
                            ],
                            [
                                'attribute' => 'lname',
                                'label' => 'Last Name',
                            ],
                            [
                                'attribute' => 'fk_employment_status',
                                'label' => 'Employment Status',
//                                'value' => function ($model) {
//                                    // Fetch the position name based on the fk_position value
//                                    $status = \app\models\EmployeesStatus::findOne($model->fk_employment_status);
//                                    return $status ? $status->status : null;
//                                },
                            ],

                            //'mname',
                            //'suffix',
                            //'bday',
                            //'gender',
                            //'contact_number',
                            //'fk_cluster',
                            //'fk_region',
                            //'fk_region_area',
                            //'fk_city',
                            //'house_address:ntext',
                            //'date_hired',
                            //'end_of_contract',
                            //'emergency_contact_persons',
                            //'emergency_contact_numbers',
                            //'emergency_contact_relations',
                            //'availability',
                            //'logged_by',
                            //'logged_time',
                            //'updated_by',
                            //'updated_time',
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
