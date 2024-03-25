<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Promos */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="promos-form">

    <div class="row">
        <div class="col-md-6">
            <?php $form = ActiveForm::begin(); ?>

            <div class="row">
                <div class="col-md-8">
                    <?= $form->field($model, 'promo')->textInput(['maxlength' => true])->label('Promo Name') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'percentage')->textInput() ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'minimum_amount')->textInput() ?>

                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'expiration_date')->widget(DatePicker::class, [
                        'options' => [
                            'class' => 'form-control',
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd',
                            'todayHighlight' => true,
                            'startDate' => 'today',
                        ],
                        'layout' => '{input}{picker}',
                    ]);
                    ?>
                </div>

            </div>


            <div class="form-group">
                <?= Html::a('<i class="fa fa-cancel"></i>&nbspCancel', Yii::$app->request->referrer ?: Yii::$app->homeUrl, ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton('<i class="fa fa-floppy-disk"></i>&nbspSave', ['class' => 'btn btn-success']) ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
