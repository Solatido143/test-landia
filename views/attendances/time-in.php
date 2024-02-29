<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\models\Attendances */
/* @var $form yii\bootstrap4\ActiveForm */

// Register the JavaScript code for the real-time clock and date
$this->registerJs("
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

<!-- Modal -->
<div class="modal fade" id="timeInModal" tabindex="-1" aria-labelledby="timeInModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="timeInModalLabel">Time In</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Container for the clock -->
                <div id="clock" class="clock mb-3"></div>
            </div>
            <div class="modal-footer">
                <!-- Form for the modal -->
                <div class="form-group">
                    <?= Html::submitButton('Cancel', ['class' => 'btn btn-secondary', 'data-bs-dismiss' => 'modal']) ?>
                    <?= Html::submitButton('Confirm', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
