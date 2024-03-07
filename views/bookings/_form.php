<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $services app\models\Services */
/* @var $form yii\bootstrap4\ActiveForm */

$bookingsModel = new \app\models\Bookings();
$customers = $bookingsModel->fetchAndMapData(\app\models\Customers::class, 'id', 'customer_name');
?>

<div class="bookings-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container">
        <div class="row">

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6 text-sm">
                        <?= $form->field($model, 'booking_type')->dropdownList([ 'Walk-in' => 'Walk-in', 'Online' => 'Online', 'Call' => 'Call', ], ['prompt' => '- Select Booking Type -', 'class' => 'form-control form-control-sm']) ?>
                    </div>
                    <div class="col-md-6 text-sm">
                        <?= $form->field($model, 'schedule_time')->widget(DateTimePicker::class, [
                            'options' => [
                                'class' => 'form-control',
                            ],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'todayHighlight' => true,
                                'todayBtn' => true,
                                'format' => 'mm-dd-yyyy H:ii:ss a'
                            ],
                            'layout' => '{input}{picker}',
                            'size' => 'sm',
                        ]);
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 text-sm">
                        <?= $form->field($model, 'fk_customer')->dropDownList(
                            ['' => '- Select Customer -'] + $customers,
                            ['class' => 'form-control form-control-sm']
                        )->label('Customer') ?>

                    </div>
                    <div class="col-md-6 text-sm d-flex align-items-center">
                        <div>
                            <?= Html::a('<i class="fas fa-person-circle-plus "></i>&nbsp Add Customer', ['/customers/create'], ['class' => 'btn btn-success']) ?>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 text-sm">
                        <?= $form->field($model, 'remarks')->textarea([
                            'rows' => 4,
                            'placeholder' => 'Enter remarks here...',
                            'class' => 'form-control form-control-sm'
                        ]) ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <?= Html::a('<i class="fas fa-cancel"></i>&nbsp Cancel', ['/bookings'], ['class' => 'btn btn-secondary']) ?>
                        <?= Html::submitButton('<i class="fas fa-forward-step"></i>&nbsp Proceed', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Services</h3>
                        <h5 class="border rounded ps-3">Total due: Php <span id="total-due"></span></h5>

                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="form-group">
                            <?= Html::a('<i class="fas fa-plus"></i>&nbsp Add Service', ['services/create'], ['class' => 'btn btn-success']) ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <?= $form->field($model, 'searchQuery')->textInput(['placeholder' => 'Search services here...'])->label(false) ?>
                    </div>
                </div>

                <?= \yii\grid\GridView::widget([
                    'dataProvider' => new \yii\data\ArrayDataProvider([
                        'allModels' => $services,
                    ]),
                    'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                    'tableOptions' => ["class" => "table table-striped table-bordered"],
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'header' => '',
                            'checkboxOptions' => function ($service, $key, $index, $column) {
                                return ['value' => $service->id];
                            }
                        ],
                        'service_name',
                        'service_fee',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs(<<<JS
$(document).ready(function() {
    // Get the total due span element
    var totalDueSpan = $('#total-due');

    // Calculate total due initially
    updateTotalDue();

    // Function to update total due
    function updateTotalDue() {
        // Get all checked checkboxes
        var checkedCheckboxes = $('input[type="checkbox"][name="selection[]"]:checked');

        // Calculate total fee
        var totalFee = 0;
        checkedCheckboxes.each(function() {
            totalFee += parseFloat($(this).closest('tr').find('td:nth-child(3)').text());
        });

        // Update total due text
        totalDueSpan.text(totalFee.toFixed(2));
    }

    // Listen for checkbox change event
    $('input[type="checkbox"][name="selection[]"]').change(function() {
        // Update total due when checkbox changes
        updateTotalDue();

        // Get an array of values of checked checkboxes
        var checkedValues = $('input[type="checkbox"][name="selection[]"]:checked').map(function() {
            return $(this).val();
        }).get();
        $('#Bookings-selectedServices').val(checkedValues.join(','));
    });
});
JS
);
?>

