<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */

$this->title = $model->customer_name;
$this->params['breadcrumbs'][] = ['label' => 'Customer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('<i class="fas fa-pencil"></i>&nbspUpdate', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <?= GridView::widget([
                                'dataProvider' => new \yii\data\ArrayDataProvider([
                                    'allModels' => [$model],
                                    'pagination' => false,
                                ]),

                                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                                'layout' => "{items}\n{pager}",
                                'columns' => [
                                    'customer_name',
                                    'contact_number',
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-6">
                            <?= GridView::widget([
                                'dataProvider' => new \yii\data\ArrayDataProvider([
                                    'allModels' => [$model],
                                    'pagination' => false,
                                ]),

                                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                                'layout' => "{items}\n{pager}",
                                'columns' => [
                                    'logged_by',
                                    'logged_time',
                                    'updated_by',
                                    'updated_time',
                                ],
                            ]);
                            ?>
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