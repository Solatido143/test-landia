<?php

use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $services app\models\Services */
/* @var $servicesModel app\models\Services */

$bookingServicesModel = new \app\models\BookingsServices();
$booking_services = $bookingServicesModel->find()->where(['fk_booking' => $model->id])->all();

$bookingsModel = new \app\models\Bookings();
$customers = $bookingsModel->fetchAndMapData(\app\models\Customers::class, 'id', 'customer_name');
?>

<div class="bookings-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="container-fluid">
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
                                'format' => 'mm-dd-yyyy HH:ii:ss'
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
                        <?= Html::a('<i class="fas fa-person-circle-plus"></i> Add Customer', ['/customers/create'], ['class' => 'btn btn-success mb-3']) ?>
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
                        <?= Html::a('<i class="fas fa-cancel"></i>&nbsp Cancel', Yii::$app->request->referrer ?: ['/bookings'], ['class' => 'btn btn-secondary']) ?>
                        <?= Html::submitButton('<i class="fas fa-forward-step"></i>&nbsp Proceed', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <h3>List of Services</h3>
                        <h5 class="border rounded ps-3">Total due: Php <span id="total-due">0.00</span></h5>

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
                            'name' => 'selectedServices[]', // Correct the name attribute
                            'checkboxOptions' => function ($service, $key, $index, $column) use ($booking_services) {
                                $isChecked = false;
                                // Check if the service exists in the booking services
                                foreach ($booking_services as $booking_service) {
                                    if ($booking_service->fk_service == $service->id) {
                                        $isChecked = true;
                                        break;
                                    }
                                }
                                return [
                                    'value' => $service->id,
                                    'data-fee' => $service->service_fee,
                                    'checked' => $isChecked,
                                ];
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
        // Fetch booking services via AJAX when the page loads
        $.ajax({
            url: '/bookings/booking-services?id=<?= $model->id ?>',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                // Iterate over the fetched services and check the corresponding checkboxes
                $.each(response, function(index, service) {
                    $('input[name="selectedServices[]"][value="' + service.fk_service + '"]').prop('checked', true);
                });
                
                // Calculate and display the total due amount
                calculateTotalDue();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });

        // Listen for changes in the checkboxes
        $('input[name="selectedServices[]"]').on('change', function() {
            // Calculate and display the total due amount
            calculateTotalDue();
        });

        // Function to calculate and display the total due amount
        function calculateTotalDue() {
            var totalDue = 0;
            $('input[name="selectedServices[]"]:checked').each(function() {
                totalDue += parseFloat($(this).data('fee'));
            });
            $('#total-due').text(totalDue.toFixed(2));
        }
    });
JS
);
?>