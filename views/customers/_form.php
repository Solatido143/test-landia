<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Customers */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="customers-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'customer_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>
        </div>

    </div>

    <div class="form-group">
        <?= Html::a('<i class="fas fa-cancel"></i> Cancel', Yii::$app->request->referrer ?: ['/customers'], ['class' => 'btn btn-danger']) ?>

        <?= Html::submitButton('<i class="fas fa-plus"></i> Save', ['class' => 'btn btn-success']) ?>
    </div>



    <?php ActiveForm::end(); ?>

</div>
