<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubProducts */
/* @var $productmodel app\models\Products */


$this->title = 'Create Sub Items';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['/products']];
$this->params['breadcrumbs'][] = [
    'label' => isset($productmodel->id) ? \app\models\Products::findOne($productmodel->id)->name : '',
    'url' => ['view', 'id' => $productmodel->id],
];
$this->params['breadcrumbs'][] = $this->title;
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