<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $form yii\bootstrap4\ActiveForm */

$todayDate = date('m-d-Y');
$employeeAttendanceTimeIn = \app\models\Attendances::find()
    ->where(['date' => $todayDate])
    ->andWhere(['sign_out_log' => null])
    ->all();

$employees = []; // Initialize an empty array to hold employees

foreach ($employeeAttendanceTimeIn as $attendance) {
    // Access the related employee model for each attendance record
    $employee = $attendance->fkEmployee;
    // Add the employee to the array
    $employees[$employee->id] = $employee->fname . ' ' . $employee->lname;
}

?>

<div class="bookings-formSelectEmployee">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'selectEmployee')->dropdownList(
                            $employees,
                            [
                                'class' => 'form-control form-control-sm',
                                'prompt' => '- Select an employee -', // Prompt text here
                            ]
                        ) ?>
                    </div>
                    <div class="col-md-12 form-group">
                        <?= Html::button('<i class="fas fa-times"></i>&nbsp; Cancel', ['class' => 'btn btn-secondary', 'onclick' => 'history.back()']) ?>
                        <?= Html::submitButton('<i class="fas fa-forward-step"></i>&nbsp Proceed', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
