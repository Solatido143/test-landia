<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Services */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="services-form">

    <?php $form = ActiveForm::begin(); ?>



    <div class="row">
        <div class="col-md-12">
            <?= $form->field($model, 'service_name')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'service_fee')->textInput(['type' => 'number', 'step' => '0.01']) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'completion_time')->textInput(['type' => 'number', 'step' => '1']) ?>


        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
