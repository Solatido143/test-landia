<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            //'id',
                            'username',
                            'fk_employee_id',
                            'email:email',
                            //'password_hash',
                            [
                                'label' => 'Status',
                                'value' => function ($model) {
                                    return $model->status === 10 ? 'Active' : 'Inactive';
                                }
                            ],
                            //'password_reset_token',
                            [
                                'label' => 'User Access',
                                'value' => function ($model) {
                                    return $model->roles->name;
                                }
                            ],
                            //'availability',
                            //'created_at',
                            //'updated_at',
                            //'auth_key',
                            //'verification_token',
                            //'managers_code',
                        ],
                    ]) ?>
                </div>
                <!--.col-md-6-->
                <div class="col-md-6">
                    <p class="text-end">
                        <?= Html::a('<i class="fas fa-pencil"></i>&nbspUpdate Details', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a('<i class="fas fa-key"></i>&nbspChange Password', ['change-password', 'id' => $model->id], ['class' => 'btn btn-success']) ?>

                    </p>
                </div>
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>