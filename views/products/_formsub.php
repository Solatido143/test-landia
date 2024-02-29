<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SubProducts */
/* @var $form yii\bootstrap4\ActiveForm */

// Fetch all main products
$mainProducts = \app\models\Products::find()->select(['id', 'product_name'])->asArray()->all();
// Map main products to use in dropdown list
$mainProductList = \yii\helpers\ArrayHelper::map($mainProducts, 'id', 'product_name');

$id = Yii::$app->request->get('id');
?>

<div class="sub-products-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList($mainProductList, [
        'prompt' => '-- Select Main Product',
        'options' => [$id => ['selected' => true]] // Pre-select the main product based on the provided ID
    ])->label('Main Product') ?>

    <?= $form->field($model, 'sub_products_name')->textInput(['maxlength' => true])->label('Sub Item Name') ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quantity')->textInput(['type' => 'number']) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>