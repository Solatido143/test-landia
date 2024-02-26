<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubProducts */

$this->title = 'Create Sub Items';
$this->params['breadcrumbs'][] = ['label' => 'Sub Products', 'url' => ['index']];
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