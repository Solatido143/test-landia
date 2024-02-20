<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EmployeesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row mt-2">
    <div class="col-md-12">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'employee_id') ?>

    <?= $form->field($model, 'fk_position') ?>

    <?= $form->field($model, 'fname') ?>

    <?= $form->field($model, 'mname') ?>

    <?php // echo $form->field($model, 'lname') ?>

    <?php // echo $form->field($model, 'suffix') ?>

    <?php // echo $form->field($model, 'bday') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'contact_number') ?>

    <?php // echo $form->field($model, 'fk_cluster') ?>

    <?php // echo $form->field($model, 'fk_region') ?>

    <?php // echo $form->field($model, 'fk_region_area') ?>

    <?php // echo $form->field($model, 'fk_city') ?>

    <?php // echo $form->field($model, 'house_address') ?>

    <?php // echo $form->field($model, 'date_hired') ?>

    <?php // echo $form->field($model, 'end_of_contract') ?>

    <?php // echo $form->field($model, 'employment_status') ?>

    <?php // echo $form->field($model, 'emergency_contact_persons') ?>

    <?php // echo $form->field($model, 'emergency_contact_numbers') ?>

    <?php // echo $form->field($model, 'emergency_contact_relations') ?>

    <?php // echo $form->field($model, 'availability') ?>

    <?php // echo $form->field($model, 'logged_by') ?>

    <?php // echo $form->field($model, 'logged_time') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>
