<?php

use app\models\EmployeesStatus;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Employees */

$this->title = $model->fname . ' ' . $model->lname;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                    <div class="row">
                        <!-- Personal Information -->
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'employee_id',
                                    [
                                        'attribute' => 'fk_position',
                                        'label' => 'Position',
                                        'value' => function ($model) {
                                            // Fetch the position name based on the fk_position value
                                            $position = \app\models\Positions::findOne($model->fk_position);
                                            return $position ? $position->position : null;
                                        },
                                    ],

                                    'date_hired',
                                    'end_of_contract',

                                    [
                                        'attribute' => 'fk_employment_status',
                                        'label' => 'Employment Status',
                                        'value' => function ($model) {
                                            // Fetch the position name based on the fk_position value
                                            $emp_status = EmployeesStatus::findOne($model->fk_employment_status);
                                            return $emp_status ? $emp_status->status : null;
                                        },
                                    ],

                                    [
                                        'attribute' => 'availability',
                                        'label' => 'Availability',
                                        'value' => function ($model) {
                                            return $model->availability ? 'Active' : 'Inactive';
                                        },
                                    ],
                                ],
                            ]) ?>
                        </div>
                        <!-- Employment Information -->
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'fname',
                                    'mname',
                                    'lname',
                                    'suffix',
                                    'bday',
                                    'gender',
                                ]
                            ]) ?>
                        </div>
                        <!-- Contact and Location Information -->
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'contact_number',
                                    [
                                        'attribute' => 'fk_cluster',
                                        'label' => 'Cluster',
                                        'value' => function ($model) {
                                            // Fetch the position name based on the fk_position value
                                            $cluster = \app\models\Clusters::findOne($model->fk_cluster);
                                            return $cluster ? $cluster->cluster : null;
                                        },
                                    ],
                                    [
                                        'attribute' => 'fk_region',
                                        'label' => 'Region',
                                        'value' => function ($model) {
                                            // Fetch the position name based on the fk_position value
                                            $region = \app\models\Regions::findOne($model->fk_region);
                                            return $region ? $region->region : null;
                                        },
                                    ],
                                    [
                                        'attribute' => 'fk_region_area',
                                        'label' => 'Province',
                                        'value' => function ($model) {
                                            // Fetch the position name based on the fk_position value
                                            $province = \app\models\Provinces::findOne($model->fk_region_area);
                                            return $province ? $province->province : null;
                                        },
                                    ],
                                    [
                                        'attribute' => 'fk_city',
                                        'label' => 'City',
                                        'value' => function ($model) {
                                            // Fetch the position name based on the fk_position value
                                            $city = \app\models\Cities::findOne($model->fk_city);
                                            return $city ? $city->city : null;
                                        },
                                    ],
                                    'house_address:ntext',
                                ],
                            ]) ?>
                        </div>
                        <!-- Emergency Contact Information -->
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'emergency_contact_persons',
                                    'emergency_contact_numbers',
                                    'emergency_contact_relations',
                                ]
                            ]) ?>
                        </div>
                        <!-- Log Information -->
                        <div class="col-md-6">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'logged_by',
                                    'logged_time',
                                    'updated_by',
                                    'updated_time',
                                ]
                            ]) ?>
                        </div>
                    </div>


                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>