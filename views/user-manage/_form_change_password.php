<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ChangePasswordForm */
/* @var $user app\models\User */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <div class="row">

                <div class="col-md-12">
                    <?= $form->field($model, 'old_password')->passwordInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'new_password')->passwordInput(['maxlength' => true])->label('New Password') ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'confirm_new_password')->passwordInput(['maxlength' => true])->label('Confirm Password') ?>
                </div>

            </div>

        </div>

    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
