<?php

use app\models\Attendances;
use app\models\Employees;
use microinginer\dropDownActionColumn\DropDownActionColumn;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\AttendancesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$fkEmployeeId = Yii::$app->user->identity->fk_employee_id;
$employee = Employees::findOne(['employee_id' => $fkEmployeeId]);
$attendance = $employee ? Attendances::find()
    ->where(['fk_employee' => $employee->id])
    ->orderBy(['id' => SORT_DESC])
    ->one() : null;

$today = date('Y-m-d');
$dataProvider->query->andWhere(['date' => $today]);

$dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

$this->title = 'Attendance';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12 text-end">
                            <?php if ($attendance === null || (!empty($attendance->sign_in) && !empty($attendance->sign_out))): ?>
                                <?= Html::a('<i class="fas fa-clock"></i>&nbsp;Time In', ['create'], ['class' => 'btn btn-success']) ?>
                            <?php elseif (empty($attendance->sign_out)): ?>
                                <?= Html::a('<i class="fas fa-clock"></i>&nbsp;Time Out', ['update', 'id' => $attendance->id], ['class' => 'btn btn-danger']) ?>
                            <?php endif; ?>
                        </div>

                    </div>

                    <!--<?php // echo $this->render('_search', ['model' => $searchModel]); ?>-->

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout' => "{items}{pager}",
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
                                        'url' => ['edit']
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
                            [
                                'attribute' => 'fk_employee',
                                'label' => 'Employee Name',
                                'value' => function ($model) {
                                    return $model->fkEmployee->fname . " " . $model->fkEmployee->lname;
                                },
                            ],
                            'date',
                            'sign_in',
                            'sign_out',
                            'remarks:ntext',
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