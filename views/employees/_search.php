<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searches\EmployeesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row mt-2">
    <div class="col col-md-12">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'd-flex justify-content-end'],
        ]); ?>

        <div class="input-group">
            <?= $form->field($model, 'searchField', [
                'options' => ['tag' => false], // Do not wrap with <div class="form-group">
                'inputOptions' => ['class' => 'form-control', 'placeholder' => "Search"],
            ])->label(false) ?>

            <div class="input-group-append">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <!--.col-md-12-->
</div>
