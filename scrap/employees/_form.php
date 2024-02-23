<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model \app\models\Employees */
/* @var $form yii\bootstrap5\ActiveForm */

// Function to fetch data from database and map it
function fetchAndMapData($modelClass, $valueField, $textField)
{
    $data = $modelClass::find()->select([$valueField, $textField])->asArray()->all();
    return \yii\helpers\ArrayHelper::map($data, $valueField, $textField);
}
$Clusters = fetchAndMapData(\app\models\Clusters::class, 'id', 'cluster');
$Regions = fetchAndMapData(\app\models\Regions::class, 'id', 'region');
$RegionAreas = fetchAndMapData(\app\models\Provinces::class, 'id', 'province');
$Cities = fetchAndMapData(\app\models\Cities::class, 'id', 'city');
$Positions = fetchAndMapData(\app\models\Positions::class, 'id', 'position');
$Status = fetchAndMapData(\app\models\EmployeesStatus::class, 'id', 'status');
?>

<div class="employees-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal', // Set form layout to horizontal
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'label' => 'col-sm-3',
                'offset' => 'col-sm-offset-3',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <?= $form->field($model, 'employee_id')->textInput(['maxlength' => true, 'disabled' => true]) ?>

    <?= $form->field($model, 'fk_position')->label('Position')->dropDownList($Positions, ['prompt' => '- Select Position']) ?>

    <?= $form->field($model, 'fname')->label('First Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mname')->label('Middle Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lname')->label('Last Name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'suffix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bday')->label('Birthday')->widget(MaskedInput::className(), [
        'mask' => '99/99/9999',
    ]); ?>

    <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => 'Choose...']) ?>

    <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_cluster')->label('Cluster')->dropDownList($Clusters, ['prompt' => '- Select Cluster']) ?>

    <?= $form->field($model, 'fk_region')->label('Region')->dropDownList($Regions, ['prompt' => '- Select Region']) ?>

    <?= $form->field($model, 'fk_region_area')->label('Region Area')->dropDownList($RegionAreas, ['prompt' => '- Select Area']) ?>

    <?= $form->field($model, 'fk_city')->label('City')->dropDownList($Cities, ['prompt' => '- Select City']) ?>

    <?= $form->field($model, 'house_address')->textarea(['rows' => 1]) ?>

    <?= $form->field($model, 'date_hired')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'end_of_contract')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'fk_employment_status')->label('Employment Status')->dropDownList($Status, ['prompt' => '- Select Status']) ?>

    <?= $form->field($model, 'emergency_contact_persons')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_numbers')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'emergency_contact_relations')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'availability')->textInput(['disabled' => true]) ?>

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