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

                <div class="col-md-6">
                    <?= $form->field($model, 'fk_employee_id')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'status')->dropDownList([
                        10 => 'Active',
                        0 => 'Inactive',
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'user_access')->dropDownList($Roles) ?>

                </div>

            </div>

        </div>
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'created_at',
                    'updated_at',
                ],
            ]) ?>

        </div>

    </div>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <hr>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <div>
                <?= $form->field($model, 'old_password')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'new_password')->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'confirm_new_password')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Change Password', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
