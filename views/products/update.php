<?php

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Update Products: ' . $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?=$this->render('_form', [
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