<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\Attendances */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Attendances';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12 text-end">
                            <!-- Button trigger modal -->
                            <?= Html::a('Time In &nbsp;<i class="fas fa-clock"></i>', null, [
                                'class' => 'btn btn-success',
                                'data-bs-toggle' => 'modal',
                                'data-bs-target' => '#timeInModal'
                            ]) ?>
                            <?php require_once ('time-in.php');?>
                        </div>
                    </div>


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'fk_employee',
                            'date',
                            'sign_in',
                            'sign_out',
                            //'remarks:ntext',
                            //'sign_in_log',
                            //'sign_out_log',

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
