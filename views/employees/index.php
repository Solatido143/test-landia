<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
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
                        <div class="col-md-12">
                            <?= Html::a('Create Employees', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>



                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
//                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'employee_id',
//                            'fk_position',
                            'fname',
                            'mname',

                            [
                                'header' => 'Actions',
                                'content' => function ($model, $key, $index, $column) {
                                    $viewButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-eye']), ['employees/view', 'id' => $model->id], ['class' => 'btn btn-primary py-0']);
                                    $updateButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-pencil']), ['employees/update', 'id' => $model->id], ['class' => 'btn btn-warning py-0']);
                                    $deleteButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-trash']), ['employees/delete', 'id' => $model->id], ['class' => 'btn btn-danger py-0', 'data-confirm' => 'Are you sure you want to delete this item?', 'data-method' => 'post',]);

                                    return $viewButton . ' ' . $updateButton . ' ' . $deleteButton;
                                },
                            ],
                            //'lname',
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
                            //'employment_status',
                            //'emergency_contact_persons',
                            //'emergency_contact_numbers',
                            //'emergency_contact_relations',
                            //'availability',
                            //'logged_by',
                            //'logged_time',
                            //'updated_by',
                            //'updated_time',

                            //['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],

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
