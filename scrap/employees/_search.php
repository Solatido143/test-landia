<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model \app\models\EmployeesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
    'options' => ['class' => 'd-flex justify-content-end'],
]); ?>

<?= $form->field($model, 'searchField')->label(false)->textInput(['placeholder' => 'Search'])->label(false) ?>

<div class="form-group ms-1">
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
