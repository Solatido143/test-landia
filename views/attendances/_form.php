<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Attendances */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="attendances-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'fk_employee')->textInput() ?>

    <?= $form->field($model, 'sign_in')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sign_out')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'sign_in_log')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sign_out_log')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
