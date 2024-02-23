<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\searches\ProductsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Products';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <?= Html::a('Create Products', ['create'], ['class' => 'btn btn-success text-nowrap']) ?>
                        </div>
                        <div class="col-12 col-md-6">
                            <?= $this->render('_search', ['model' => $searchModel]); ?>
                        </div>
                    </div>


                    <?php
                    $dataProvider->query->andWhere(['isRemove' => 0]); // Filter out rows where 'isRemove' is true
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'tableOptions' => ["class" => "table-responsive-md table table-striped table-bordered"],
                        'columns' => [
                            [
                                'header' => 'Actions',
                                'contentOptions' => ['style' => 'white-space: nowrap;'], // Prevent content from wrapping
                                'content' => function ($model) {
                                    $viewButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-eye']), ['products/view', 'id' => $model->id], ['class' => 'btn btn-primary py-0', 'style' => 'display: inline-block;']);
                                    $updateButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-pencil']), ['products/update', 'id' => $model->id], ['class' => 'btn btn-warning py-0', 'style' => 'display: inline-block;']);
                                    $deleteButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-trash']), ['products/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-danger py-0',
                                        'style' => 'display: inline-block;',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to delete this item?',
                                            'method' => 'post',
                                        ],
                                    ]);

                                    return $viewButton . ' ' . $updateButton . ' ' . $deleteButton;
                                },
                            ],
                            [
                                'attribute' => 'id',
                                'label' => 'ID',
                            ],
                            'name',
                            [
                                'attribute' => 'description',
                                'format' => 'ntext',
                                'value' => function ($model) {
                                    return \yii\helpers\StringHelper::truncate($model->description, 50); // Adjust the number of characters as needed
                                },
                            ],
                            'price',
                            'stock_quantity',
                        ],
                        'summaryOptions' => ['class' => 'summary mb-2'],
                        'pager' => [
                            'class' => 'yii\bootstrap4\LinkPager',
                        ],
                    ]);
                    ?>

                </div><!-- .card-body -->
            </div><!-- .card -->
        </div><!-- .col-md-12 -->
    </div><!-- .row -->
</div><!-- .container -->
