<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <?= Html::a('Create Products', ['create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>


                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [
                            [
                                'header' => 'Actions',
                                'contentOptions' => ['style' => 'white-space: nowrap;'], // Prevent content from wrapping
                                'content' => function ($model) {
                                    $viewButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-eye']), ['products/view', 'id' => $model->id], ['class' => 'btn btn-primary py-0', 'style' => 'display: inline-block;']);
                                    $updateButton = Html::a(Html::tag('i', '', ['class' => 'fas fa-pencil']), ['products/update', 'id' => $model->id], ['class' => 'btn btn-warning py-0', 'style' => 'display: inline-block;']);
                                    $deleteButton = Html::button(Html::tag('i', '', ['class' => 'fas fa-trash']), [
                                        'class' => 'btn btn-danger py-0',
                                        'style' => 'display: inline-block;',
                                        'data-bs-toggle' => 'modal',
                                        'data-bs-target' => '#deleteModal' . $model->id, // Unique ID for each modal
                                    ]);

                                    // Modal content
                                    $modal = '<div class="modal fade" id="deleteModal' . $model->id . '" tabindex="-1" aria-labelledby="deleteModalLabel' . $model->id . '" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="deleteModalLabel' . $model->id . '">Delete? :(</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete this item?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary" id="confirmDelete' . $model->id . '">Confirm</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';

                                    // Register modal script
                                    $this->registerJs('
                                        $(document).ready(function(){
                                            $("#deleteModal' . $model->id . '").modal("hide");
                                            $("#confirmDelete' . $model->id . '").click(function() {
                                                $("#deleteForm' . $model->id . '").submit();
                                            });
                                        });
                                    ');

                                    // Form for delete action
                                    $form = Html::beginForm(['products/delete', 'id' => $model->id], 'post', ['id' => 'deleteForm' . $model->id, 'style' => 'display: none;']);
                                    $form .= Html::endForm();

                                    return $viewButton . ' ' . $updateButton . ' ' . $deleteButton . $modal . $form;
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
