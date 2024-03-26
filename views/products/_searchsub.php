<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searches\SubProductsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => ['class' => 'd-sm-flex justify-content-end'],
]); ?>

<?= $form->field($model, 'searchField')->textInput(['placeholder' => 'Search'])->label(false) ?>

<div class="form-group ms-1 text-nowrap">
    <?= Html::submitButton('<i class="fas fa-magnifying-glass"></i> Search', ['class' => 'btn btn-primary']) ?>
    <?= Html::resetButton('<i class="fas fa-undo"></i> Reset', ['class' => 'btn btn-outline-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>

