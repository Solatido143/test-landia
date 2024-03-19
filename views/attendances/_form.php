<?php

use app\models\Attendances;
use app\models\Employees;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Attendances */
/* @var $form yii\bootstrap4\ActiveForm */

$fkEmployeeId = Yii::$app->user->identity->fk_employee_id;
$employee = Employees::findOne(['employee_id' => $fkEmployeeId]);
$attendance = $employee ? Attendances::find()
    ->where(['fk_employee' => $employee->id])
    ->orderBy(['id' => SORT_DESC])
    ->one() : null;

// Register the JavaScript code for the real-time clock and date
$this->registerJs("
    console.log('JavaScript code is executing.'); // Check if JavaScript is executing

    function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var day = now.getDate();
        var month = now.getMonth() + 1; // Month is zero-based
        var year = now.getFullYear();
        var meridiem = hours >= 12 ? 'PM' : 'AM';

        // Convert hours to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // 0 should be converted to 12

        // Add leading zeros if needed
        hours = (hours < 10 ? '0' : '') + hours;
        minutes = (minutes < 10 ? '0' : '') + minutes;
        seconds = (seconds < 10 ? '0' : '') + seconds;
        day = (day < 10 ? '0' : '') + day;
        month = (month < 10 ? '0' : '') + month;

        // Display the date and time in the format: YYYY-MM-DD HH:MM:SS AM/PM
        var dateTimeString = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds + ' ' + meridiem;

        // Update the clock element
        document.getElementById('clock').textContent = dateTimeString;
    }

    // Update the clock every second
    setInterval(updateClock, 1000);

    // Initial call to display the clock immediately
    updateClock();
", View::POS_READY);
?>

<div class="attendances-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="d-flex justify-content-center align-items-center flex-column">
        <div id="clock" class="clock mb-3"></div>

        <?php if ($attendance === null || !empty($attendance->sign_in && !empty($attendance->sign_out))) : ?>
            <div class="form-group">
                <?= Html::submitButton('Time In', ['class' => 'btn btn-success']) ?>
            </div>
        <?php elseif (empty($attendance->sign_out)): ?>
            <div class="form-group">
                <?= Html::submitButton('Time Out', ['class' => 'btn btn-danger']) ?>
            </div>
        <?php endif; ?>
    </div>



    <div class="d-none">
        <?= $form->field($model, 'fk_employee')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'sign_in')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'sign_in_log')->hiddenInput()->label(false) ?>
    </div>


    <?php ActiveForm::end(); ?>

</div>
