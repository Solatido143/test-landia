<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searches\ProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-md-12">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'd-md-flex justify-content-end'],
        ]); ?>

        <?= $form->field($model, 'searchQuery')->textInput(['placeholder' => 'Search'])->label(false) ?>

        <div class="form-group ms-1 text-nowrap">
            <?= Html::submitButton('<i class="fa fa-magnifying-glass"></i> Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('<i class="fa fa-undo"></i> Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>
