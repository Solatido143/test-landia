<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="bookings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'booking_type')->dropDownList([ 'Walk-in' => 'Walk-in', 'Online' => 'Online', 'Call' => 'Call', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'fk_customer')->textInput() ?>

    <?= $form->field($model, 'fk_booking_status')->textInput() ?>

    <?= $form->field($model, 'schedule_time')->textInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'remarks')->textarea(['rows' => 6]) ?>

<!--    --><?php //= $form->field($model, 'logged_by')->textInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'logged_time')->textInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

<!--    --><?php //= $form->field($model, 'updated_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
