<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Employees */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p class="d-flex">
                        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                            'class' => 'btn btn-danger ms-2',
                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                        <?= Html::a('Back', ['index'], ['class' => 'btn btn-outline-secondary ms-auto']) ?>
                    </p>

                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'id',
                            'employee_id',
                            'fk_position',
                            'fname',
                            'mname',
                            'lname',
                            'suffix',
                            'bday',
                            'gender',
                            'contact_number',
                            'fk_cluster',
                            'fk_region',
                            'fk_region_area',
                            'fk_city',
                            'house_address:ntext',
                            'date_hired',
                            'end_of_contract',
                            'employment_status',
                            'emergency_contact_persons',
                            'emergency_contact_numbers',
                            'emergency_contact_relations',
                            'availability',
                            'logged_by',
                            'logged_time',
                            'updated_by',
                            'updated_time',
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>