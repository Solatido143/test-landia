<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Employees */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="employees-form">
    <?php $form = ActiveForm::begin(); ?>


    <div class="row align-items-center g-3">
        <div class="col-md-3">
            <?= $form->field($model, 'fname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'mname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'lname')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-1">
            <?= $form->field($model, 'suffix')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'bday')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '']) ?>

        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-6">
        </div>

        <div class="col-md-12">

            <!--    --><?php //= $form->field($model, 'employee_id')->textInput(['maxlength' => true]) ?>

            <!--    --><?php //= $form->field($model, 'fk_position')->textInput() ?>

            <!--    --><?php //= $form->field($model, 'fk_cluster')->textInput() ?>

            <!--    --><?php //= $form->field($model, 'fk_region')->textInput() ?>

            <!--    --><?php //= $form->field($model, 'fk_region_area')->textInput() ?>

            <!--    --><?php //= $form->field($model, 'fk_city')->textInput() ?>

            <?= $form->field($model, 'house_address')->textarea(['rows' => 3]) ?>

            <?= $form->field($model, 'date_hired')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'end_of_contract')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'employment_status')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'emergency_contact_persons')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'emergency_contact_numbers')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'emergency_contact_relations')->textInput(['maxlength' => true]) ?>

            <!--    --><?php //= $form->field($model, 'availability')->textInput() ?>

            <!--    --><?php //= $form->field($model, 'logged_by')->textInput(['maxlength' => true]) ?>

            <!--    --><?php //= $form->field($model, 'logged_time')->textInput(['maxlength' => true]) ?>

            <!--    --><?php //= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>

            <!--    --><?php //= $form->field($model, 'updated_time')->textInput(['maxlength' => true]) ?>

        </div>

    </div>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
