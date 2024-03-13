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
                        <?= $form->field($servicesModel, 'searchQuery')->textInput(['placeholder' => 'Search services here...'])->label(false) ?>
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
// Register JavaScript to calculate the total due based on the checkbox values and handle service deletion
$this->registerJs(<<<JS
    $(document).ready(function() {
        // Calculate total due initially
        updateTotalDue();
    
        // Function to update total due
        function updateTotalDue() {
            var totalFee = 0;
            // Iterate over each checked checkbox
            $('input[type="checkbox"][name="selectedServices[]"]:checked').each(function() {
                // Extract the fee from the data attribute
                var serviceFee = parseFloat($(this).data('fee'));
                totalFee += serviceFee; // Add the fee to the total
            });
            // Update the total due span with the calculated total fee
            $('#total-due').text(totalFee.toFixed(2));
        }
    
        // Listen for checkbox change event and update total due
        $('input[type="checkbox"][name="selectedServices[]"]').change(function() {
            updateTotalDue();
        });

        // Listen for checkbox uncheck event and remove associated service
        $('input[type="checkbox"][name="selectedServices[]"]').on('change', function() {
            var serviceId = $(this).val();
            if (!$(this).prop('checked')) { // If the checkbox is unchecked
                // Remove the associated service
                $.ajax({
                    url: '/bookings/remove-service',
                    method: 'POST',
                    data: { serviceId: serviceId, bookingId: $model->id },
                    success: function(response) {
                        // Optionally, handle success response here
                        console.log('Service removed successfully');
                    },
                    error: function(xhr, status, error) {
                        // Optionally, handle error here
                        console.error('Error removing service:', error);
                    }
                });
            }
        });
    });
JS
);
?>