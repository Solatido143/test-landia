<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $form yii\bootstrap4\ActiveForm */

$employeesData = \app\models\Employees::find()
    ->select(['id', 'CONCAT(fname, " ", lname) AS full_name'])
    ->where(['availability' => 1])
    ->asArray()
    ->all();

$employees = \yii\helpers\ArrayHelper::map($employeesData, 'id', 'full_name');

?>

<div class="bookings-formSelectEmployee">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'select_Employee')->dropdownList(
                            $employees,
                            ['class' => 'form-control form-control-sm']
                        ) ?>
                    </div>
                    <div class="col-md-12 form-group">
                        <?= Html::button('<i class="fas fa-times"></i>&nbsp; Cancel', ['class' => 'btn btn-secondary', 'onclick' => 'history.back()']) ?>
                        <?= Html::submitButton('<i class="fas fa-forward-step"></i>&nbsp Proceed', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
