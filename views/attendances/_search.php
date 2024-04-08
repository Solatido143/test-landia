<?php

use app\models\Employees;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\searches\AttendancesSearch */
/* @var $form yii\widgets\ActiveForm */

$employees = Employees::find()->select(['id', 'CONCAT(fname, " ", lname) AS full_name'])->asArray()->all();
$employeeList = ArrayHelper::map($employees, 'id', 'full_name');
?>

<div class="row mt-2">
    <div class="col-md-12">

        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options' => ['class' => 'd-md-flex justify-content-start'],
        ]); ?>

        <?= $form->field($model, 'searchQuery')->dropDownList(
            $employeeList,
            ['prompt' => '- Select Employee']
        )->label(false) ?>

        <div class="form-group ms-1 text-nowrap ">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
    <!--.col-md-12-->
</div>