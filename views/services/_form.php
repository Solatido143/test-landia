<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Services */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'service_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'service_fee')->textInput() ?>

    <?= $form->field($model, 'completion_time')->textInput() ?>

    <?= $form->field($model, 'logged_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'logged_time')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'updated_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
