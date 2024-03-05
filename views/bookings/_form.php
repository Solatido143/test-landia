<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $services app\models\Services */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="bookings-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'booking_type')->dropdownList([ 'Walk-in' => 'Walk-in', 'Online' => 'Online', 'Call' => 'Call', ], ['prompt' => '- Select Booking Type -']) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'fk_customer')->textInput() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'schedule_time')->textInput(['maxlength' => true]) ?>

        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'remarks')->textarea(['rows' => 4]) ?>

        </div>
    </div>

    <hr>

    <?= DetailView::widget([
        'model' => $services, // should be an instance of Services, not an array
        'attributes' => [
            'id',
            'service_name',
            // Add more attributes from Services model as needed
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
