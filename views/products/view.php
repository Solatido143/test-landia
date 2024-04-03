<?php

use microinginer\dropDownActionColumn\DropDownActionColumn;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\SubProductsSearch */
/* @var $model app\models\Products */

$this->title = $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$hasSubItem = \app\models\SubProducts::find()
    ->where(['product_id' => $model->id])
    ->one();
?>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="d-flex justify-content-between mb-3">
                                        <div>
                                            <?= Html::a('<i class="fa fa-pencil"></i>&nbspUpdate', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                        </div>
                                        <div>
                                            <?= Html::a('<i class="fas fa-plus"></i> Add sub-items', ['sub-items-create', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                        </div>
                                    </div>
                                    <?= DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            'product_name',
                                            'description:ntext',
                                            'stock_quantity',
                                        ],
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

        <?php if (!empty($hasSubItem)) : ?>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-md-flex justify-content-md-between">
                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="mb-3 me-2">Sub Items</h4>
                                </div>
<!--                                <div class="row">-->
<!--                                    <div class="col-md-12">-->
<!--                                        --><?php //= $this->render('_searchsub', ['model' => $searchModel]); ?>
<!--                                    </div>-->
<!--                                </div>-->
                            </div>
                            <?= GridView::widget([
                                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                'dataProvider' => new \yii\data\ActiveDataProvider([
                                    'query' => $model->getSubProducts()->orderBy(['id' => SORT_DESC]),
                                    'pagination' => [
                                        'pageSize' => 5,
                                    ],
                                ]),
                                'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                                'layout' => '{items}{pager}',
                                'columns' => [
                                    ['class' => 'yii\grid\SerialColumn'],
                                    [
                                        'class' => DropDownActionColumn::className(),
                                        'header' => 'Actions',
                                        'contentOptions' => ['style' => 'white-space: nowrap; width: 10%;'],
                                        'items' => [
                                            [
                                                'label' => '<i class="fas fa-pencil"></i> Update',
                                                'url' => ['sub-items-update']
                                            ],
                                        ],
                                    ],
                                    'sub_products_name',
                                    'description',
                                    'quantity',
                                ],
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--card-->
        </div>
        <?php endif; ?>

    </div>



</div>
