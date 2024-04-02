<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\bootstrap4\ActiveForm */

$UserModel = new \app\models\User();
$Roles = $UserModel->fetchAndMapData(\app\models\Roles::class, 'user_access_id', 'name');

?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <div class="row">

                <div class="col-md-12">
                    <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'password')->textInput(['maxlength' => true])->label('New Password') ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'confirmPassword')->textInput(['maxlength' => true])->label('Confirm Password') ?>
                </div>

            </div>

        </div>

    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
