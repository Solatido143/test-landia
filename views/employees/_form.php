<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Employees */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="employees-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'employee_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_position')->textInput() ?>

    <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suffix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bday')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_cluster')->textInput() ?>

    <?= $form->field($model, 'fk_region')->textInput() ?>

    <?= $form->field($model, 'fk_region_area')->textInput() ?>

    <?= $form->field($model, 'fk_city')->textInput() ?>

    <?= $form->field($model, 'house_address')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_hired')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_of_contract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_employment_status')->textInput() ?>

    <?= $form->field($model, 'emergency_contact_persons')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_numbers')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_relations')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <!--    --><?php //= $form->field($model, 'availability')->textInput() ?>
    <!--    --><?php //= $form->field($model, 'logged_by')->textInput(['maxlength' => true]) ?>
    <!--    --><?php //= $form->field($model, 'logged_time')->textInput(['maxlength' => true]) ?>
    <!--    --><?php //= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>
    <!--    --><?php //= $form->field($model, 'updated_time')->textInput(['maxlength' => true]) ?>

    <?php ActiveForm::end(); ?>

</div>
