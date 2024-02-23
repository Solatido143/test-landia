<?php

use app\models\Positions;
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


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ["class" => "table-responsive-md table table-striped table-bordered text-nowrap"],
                        'columns' => [
                            [
                                'header' => 'Actions',
                                'contentOptions' => ['style' => 'white-space: nowrap;'], // Prevent content from wrapping
                                'content' => function ($model) {
                                    $viewButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-eye']), ['employees/view', 'id' => $model->id], ['class' => 'btn btn-primary py-0', 'style' => 'display: inline-block;']);
                                    $updateButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-pencil']), ['employees/update', 'id' => $model->id], ['class' => 'btn btn-warning py-0', 'style' => 'display: inline-block;']);
                                    $deleteButton = Html::a(
                                        Html::tag('i', '', ['class' => 'fas fa-trash']),
                                        ['employees/delete', 'id' => $model->id],
                                        [
                                            'class' => 'btn btn-danger py-0 d-inline-block',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to delete this item?',
                                                'method' => 'post',
                                            ],
                                        ]
                                    );


                                    return $viewButton . ' ' . $updateButton . ' ' . $deleteButton;
                                },
                            ],
                            'id',
                            'employee_id',
                            [
                                'attribute' => 'fk_position',
                                'label' => 'Position',
                                'value' => function ($model) {
                                    // Fetch the position name based on the fk_position value
                                    $position = Positions::findOne($model->fk_position);
                                    return $position ? $position->position : null;
                                },
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
                                'value' => function ($model) {
                                    // Fetch the position name based on the fk_position value
                                    $status = \app\models\EmployeesStatus::findOne($model->fk_employment_status);
                                    return $status ? $status->status : null;
                                },
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
