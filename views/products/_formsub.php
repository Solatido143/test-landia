<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubProducts */
/* @var $form yii\bootstrap4\ActiveForm */

// Fetch all main products
$mainProducts = \app\models\Products::find()->select(['id', 'name'])->asArray()->all();

// Map main products to use in dropdown list
$mainProductList = \yii\helpers\ArrayHelper::map($mainProducts, 'id', 'name');
?>

<div class="sub-products-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sub_product_id')->dropDownList($mainProductList, ['prompt' => '-- Select Main Product']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
