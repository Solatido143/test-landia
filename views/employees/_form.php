<?php

use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Employees */
/* @var $form yii\bootstrap4\ActiveForm */

$employeesModel = new \app\models\Employees();
$clusters = $employeesModel->fetchAndMapData(\app\models\Clusters::class, 'id', 'cluster');
$regions = $employeesModel->fetchAndMapData(\app\models\Regions::class, 'id', 'region');
$provinces = $employeesModel->fetchAndMapData(\app\models\Provinces::class, 'id', 'province');
$cities = $employeesModel->fetchAndMapData(\app\models\Cities::class, 'id', 'city');
$position = $employeesModel->fetchAndMapData(\app\models\Positions::class, 'id', 'position');
$Status = $employeesModel->fetchAndMapData(\app\models\EmployeesStatus::class, 'id', 'status');
?>

<div class="employees-form">
    <?php $form = ActiveForm::begin(); ?>

    <!-- Personal Information -->
    <div class="row">
        <div class="col-12 col-md-12">
            <label for="personal_info">Personal Information</label>
        </div>
        <div class="col-12" id="personal_info">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'fname')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm'])->label('First Name') ?>

                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'mname')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm'])->label('Middle Name') ?>

                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'lname')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm'])->label('Last Name') ?>

                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'suffix')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>

                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'gender')->dropDownList([ 'Male' => 'Male', 'Female' => 'Female', ], ['prompt' => '-- Select', 'class' => 'form-control form-control-sm']) ?>

                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'bday')->widget(DatePicker::class, [
                        'options' => [
                            'placeholder' => 'Select date',
                            'class' => 'form-control',
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'mm-dd-yyyy',
                            'todayHighlight' => true,
                        ],
                        'layout' => '{input}{picker}',
                        'size' => 'sm',
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-12 col-md-4">
            <label for="contact_info">Contact Information</label>
        </div>
        <div class="col-md-12" id="contact_info">
            <div class="row">
                <div class="col-md-3 text-sm">
                    <?= $form->field($model, 'fk_cluster')->dropDownList($clusters,
                        ['prompt' => '-- Select Cluster', 'class' => 'form-control form-control-sm', 'id' => 'fk_cluster']
                    )->label('Cluster') ?>
                </div>
                <div class="col-md-3 text-sm">
                    <?= $form->field($model, 'fk_region')->dropDownList($regions,
                        ['prompt' => '-- Select Region', 'class' => 'form-control form-control-sm', 'id' => 'fk_region'],
                    )->label('Region') ?>
                </div>
                <div class="col-md-3 text-sm">
                    <?= $form->field($model, 'fk_region_area')->dropDownList($provinces,
                        ['prompt' => '-- Select Province', 'class' => 'form-control form-control-sm', 'id' => 'fk_province']
                    )->label('Province') ?>
                </div>
                <div class="col-md-3 text-sm">
                    <?= $form->field($model, 'fk_city')->dropDownList($cities,
                        ['prompt' => '-- Select City', 'class' => 'form-control form-control-sm', 'id' => 'fk_city']
                    )->label('City') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'house_address')->textarea(['rows' => 3, 'class' => 'form-control form-control-sm']) ?>

                </div>
                <div class="col-md-3 text-sm">
                    <?= $form->field($model, 'contact_number')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>

                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Employment Details -->
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="employ_dtls">Employment Details</label>
        </div>
        <div class="col-md-12" id="employ_dtls">
            <div class="row">
                <div class="col-md-3 text-sm">
                    <?= $form->field($model, 'employee_id')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm']) ?>
                </div>
                <div class="col-md-3 text-sm">
                    <?= $form->field($model, 'fk_position')->dropDownList($position, ['prompt' => '-- Select Position', 'class' => 'form-control form-control-sm', 'id' => 'employees-fk_position'])->label('Position') ?>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 text-sm">
                            <?= $form->field($model, 'date_hired')->widget(DatePicker::class, [
                                'options' => [
                                    'placeholder' => 'Select date',
                                    'class' => 'form-control',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'mm-dd-yyyy',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                ],
                                'layout' => '{input}{picker}',
                                'size' => 'sm',
                            ]);
                            ?>
                        </div>
                        <div class="col-md-3 text-sm">
                            <?= $form->field($model, 'end_of_contract')->widget(DatePicker::class, [
                                'options' => [
                                    'placeholder' => 'Select date',
                                    'class' => 'form-control',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'mm-dd-yyyy',
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                ],
                                'layout' => '{input}{picker}',
                                'size' => 'sm',
                            ]);
                            ?>
                        </div>
                        <div class="col-md-3 text-sm">
                            <?= $form->field($model, 'fk_employment_status')->dropDownList($Status, ['prompt' => '-- Select Status', 'class' => 'form-control form-control-sm'])->label('Status') ?>
                        </div>
                        <div class="col-md-2 text-sm">
                            <?= $form->field($model, 'availability')->dropDownList(
                                ['' => '','1' => 'Active', '0' => 'Inactive'],
                                ['class' => 'form-control form-control-sm', 'id' => 'availability-field']
                            )->label('Availability') ?>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr>

    <!-- Emergency Contact -->
    <div class="row">
        <div class="col-12 col-md-4">
            <label for="emrgncy_contact">Emergency Contact</label>
        </div>
        <div class="col-md-12" id="emrgncy_contact">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'emergency_contact_persons')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm'])->label('Person') ?>

                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'emergency_contact_numbers')->textInput(['maxlength' => true, 'class' => 'form-control form-control-sm'])->label('Phone Number') ?>

                </div>
                <div class="col-md-3">
                    <?php
                    $relationOptions = [
                        'Parent' => 'Parent',
                        'Sibling' => 'Sibling',
                        'Spouse' => 'Spouse',
                        'Child' => 'Child',
                        'Relative' => 'Relative',
                        'Friend' => 'Friend',
                    ];
                    ?>
                    <?= $form->field($model, 'emergency_contact_relations')->widget(Select2::className(), [
                        'data' => $relationOptions,  // Pass the options array
                        'options' => [
                            'placeholder' => '-- Select Relationship --',
                            'allowClear' => true,
                            'class' => 'form-control form-control-sm',
                        ],
                        'pluginOptions' => [
                            'tags' => true,  // Allow users to create new options
                            'dropdownAutoWidth' => true,
                            'width' => '100%',
                        ],
                        'size' => 'sm',
                    ])->label('Relationship'); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('<i class="fas fa-times"></i> Cancel', ['index'], ['class' => 'btn btn-secondary']) ?>
        <?= Html::submitButton('<i class="fas fa-save"></i> Save', ['class' => 'btn btn-success']) ?>

    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$script = <<< JS

$('#employees-fk_position').change(function(){
    var id = $(this).val();
    $.ajax({
        url: '/employees/get-position-availability',
        method: 'GET',
        data: {id: id},
        success: function(response){
            $('#availability-field').val(response);
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
        }
    });
});

$('#fk_cluster').change(function(){
    var id = $(this).val();
    $.ajax({
        url: '/employees/get-regions', // Update the URL with your actual controller/action
        method: 'GET',
        data: {id: id}, // Update the parameter name to match the action parameter
        success: function(response){
            $('#fk_region').html(response);
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
        }
    });
});

$('#fk_region').change(function(){
    var id = $(this).val();
    $.ajax({
        url: '/employees/get-provinces', // Update the URL with your actual controller/action
        method: 'GET',
        data: {id: id}, // Update the parameter name to match the action parameter
        success: function(response){
            $('#fk_province').html(response);
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
        }
    });
});

$('#fk_province').change(function(){
    var id = $(this).val();
    $.ajax({
        url: '/employees/get-cities', // Update the URL with your actual controller/action
        method: 'GET',
        data: {id: id}, // Update the parameter name to match the action parameter
        success: function(response){
            $('#fk_city').html(response);
        },
        error: function(xhr, status, error){
            console.error(xhr.responseText);
        }
    });
});

JS;

$this->registerJs($script);
?>