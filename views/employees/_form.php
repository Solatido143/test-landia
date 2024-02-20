<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\Employees */
/* @var $form yii\bootstrap5\ActiveForm */

$Cluster = \app\models\Clusters::find()->select('id, cluster')->asArray()->all();
$Cluster = \yii\helpers\ArrayHelper::map($Cluster, 'id', 'cluster');

$Region = \app\models\Regions::find()->select('id, region')->asArray()->all();
$Region = \yii\helpers\ArrayHelper::map($Region, 'id', 'region');

$Region_area = \app\models\Provinces::find()->select('id, province')->asArray()->all();
$Region_area = \yii\helpers\ArrayHelper::map($Region_area, 'id', 'province');

$City = \app\models\Cities::find()->select('id, city')->asArray()->all();
$City = \yii\helpers\ArrayHelper::map($City, 'id', 'city');
?>

<div class="employees-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal', // Set form layout to horizontal
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-3', // Label column width
                'offset' => 'col-sm-offset-3', // Offset for the entire row
                'wrapper' => 'col-sm-9', // Input field column width
                'error' => '', // No error message column
                'hint' => '', // No hint message column
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'employee_id')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'fk_position')->label('Position')->textInput() ?>

    <?= $form->field($model, 'fname')->label('First Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mname')->label('Middle Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lname')->label('Last Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suffix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bday')->label('Birthday')->widget(MaskedInput::className(), [
        'mask' => '99/99/9999',
        'options' => ['class' => 'form-control'],
    ]); ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => 'Choose...']) ?>

    <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_cluster')->label('Cluster')->dropDownList($Cluster, ['prompt' => '- Select Cluster']) ?>

    <?= $form->field($model, 'fk_region')->label('Region')->dropDownList($Region, ['prompt' => '- Select Region']) ?>

    <?= $form->field($model, 'fk_region_area')->label('Region Area')->dropDownList($Region_area, ['prompt' => '- Select Area']) ?>

    <?= $form->field($model, 'fk_city')->label('City')->dropDownList($City, ['prompt' => '- Select City']) ?>

    <?= $form->field($model, 'house_address')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'date_hired')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_of_contract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'employment_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_persons')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_numbers')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_relations')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'availability')->textInput() ?>

<!--    --><?php //= $form->field($model, 'logged_by')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?php //= $form->field($model, 'logged_time')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?php //= $form->field($model, 'updated_by')->textInput(['maxlength' => true]) ?>
<!---->
<!--    --><?php //= $form->field($model, 'updated_time')->textInput(['maxlength' => true]) ?>

    <div class="form-group float-right">
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