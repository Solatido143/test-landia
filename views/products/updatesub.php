<?php

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Update Sub Item: ' . $model->sub_products_name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['products']];
$this->params['breadcrumbs'][] = [
    'label' => isset($model->product_id) ? \app\models\Products::findOne($model->product_id)->product_name : '',
    'url' => ['view', 'id' => $model->product_id],
];
$this->params['breadcrumbs'][] = ['label' => $model->sub_products_name, 'url' => ['sub-items-view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?=$this->render('_formsub', [
                                'model' => $model
                            ]) ?>
                        </div>
                    </div>
                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
    </div>

</div>