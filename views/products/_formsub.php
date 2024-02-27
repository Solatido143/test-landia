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

$id = Yii::$app->request->get('id');
?>

<div class="sub-products-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'product_id')->dropDownList($mainProductList, [
        'prompt' => '-- Select Main Product',
        'options' => [$id => ['selected' => true]] // Pre-select the main product based on the provided ID
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>


    <div class="row">
        <div class="col-12">
            <div class="your-custom-class">
                <?= Html::label('Quantity', ['class' => 'control-label']) ?>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <?= $form->field($model, 'quantity')->textInput(['type' => 'number'])->label(false) ?>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="input-group mb-3">
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-minus"></i></button>
                            <?= $form->field($model, 'calcu', ['options' => ['class' => 'input-group-prepend']])->textInput(['type' => 'text', 'class' => 'form-control', 'placeholder' => "Integer",])->label(false) ?>
                            <button class="btn btn-outline-secondary" type="button"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>


        </div>


        <div class="col">

        </div>


    </div>





    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
