<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="products-form">

    <?php $form = ActiveForm::begin([
        'options' => [
            'class' => 'row g-3',
        ]
    ]); ?>
    <div class="col-md-6">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-6">
        <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => .01]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'description')->label('Remarks')->textarea(['rows' => 6]) ?>

    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'stock_quantity')->textInput(['type' => 'number']) ?>

    </div>



    <div class="col-md-6">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        <?= Html::button('Cancel', ['class' => 'btn btn-danger', 'id' => 'cancelButton']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs("
    $('#cancelButton').click(function() {
        window.location.href = '" . Yii::$app->request->referrer . "';
    });
");
?>
