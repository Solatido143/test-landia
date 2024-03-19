<?php

use app\models\Promos;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $paymentModel app\models\Payments */
/* @var $dataProvider app\models\BookingsServices */
/* @var $form yii\bootstrap4\ActiveForm */

// Fetch promos data
$promos = $paymentModel->fetchAndMapData(\app\models\Promos::class, 'id', 'promo');

// Initialize dropdown list options with 'None'
$promosOption = [];

// Check if $promos contains valid data
if ($promos) {
    // Iterate over each promo and construct the option label
    foreach ($promos as $promoId => $promoName) {
        $promo = Promos::findOne($promoId);

        // Check if the promo's expiration date is not in the past
        if ($promo && strtotime($promo->expiration_date) >= strtotime(date('Y-m-d'))) {
            $label = $promoName . ' (' . $promo->percentage . '%)';
            $promosOption[$promoId] = $label;
        }
    }
}
?>

<div class="payment-form">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-5">
                <!--Bookings Services GridView-->
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'pagination' => [
                        ''
                    ],
                    'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                    'tableOptions' => ["class" => "table table-striped table-bordered"],
                    'layout' => "{items}\n{pager}",
                    'columns' => [
                        [
                            'attribute' => 'fk_service',
                            'label' => 'Service Name',
                            'value' => function ($model) {
                                // Access the related Service model
                                $service = $model->fkService;
                                // Check if the service exists
                                if ($service !== null) {
                                    // Return the service name
                                    return $service->service_name;
                                } else {
                                    return null; // or any default value
                                }
                            },
                        ],
                        [
                            'attribute' => 'fk_service',
                            'label' => 'Service Fee',
                            'value' => function ($model) {
                                // Access the related Service model
                                $service = $model->fkService;
                                // Check if the service exists
                                if ($service !== null) {
                                    // Return the service fee
                                    return '₱' . $service->service_fee;
                                } else {
                                    return null; // or any default value
                                }
                            },
                        ],
                    ],
                    'pager' => [
                        'class' => 'yii\bootstrap4\LinkPager',
                    ]
                ]);
                ?>

            </div>
            <div class="col-md-7">

                <?php $form = ActiveForm::begin(); ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6 p-0">
                            <?= $form->field($paymentModel, 'payment_amount')->textInput(['readonly' => true, 'id' => 'payment_amount'])->label('Payment Total') ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($paymentModel, 'mode_of_payment')->dropdownList(
                            [
                                'Cash' => 'Cash',
                                'GCash' => 'GCash',
                                'Paymaya' => 'Paymaya',
                                'Debit Card' => 'Debit Card',
                                'Credit Card' => 'Credit Card',
                            ],
                            ['prompt' => '- Select Mode of Payment -']
                        ) ?>
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($paymentModel, 'promo')->dropdownList(
                            $promosOption,
                            ['id' => 'promo', 'prompt' => '- Select promo']
                        ) ?>
                    </div>


                    <div class="col-md-4">
                        <?= $form->field($paymentModel, 'discount')->textInput(['readonly' => true, 'type' => 'number', 'id' => 'discount'])->label('Discounted Price') ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'amount_tendered')->textInput(['type' => 'number', 'id' => 'amount_tendered', 'step' => '0.01']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'change')->textInput(['readonly' => true, 'id' => 'change']) ?>
                    </div>

                </div>

                <hr>

                <?= $form->field($paymentModel, 'total_due')->textInput(['type' => 'hidden', 'id' => 'total_due', 'value' => '0.00', 'step' => '0.01'])->label(false) ?>

                <div class="d-flex g-3 justify-content-between">
                    <h3 class="m-0">Total due: <span id="total-due">0.00</span></h3>
                    <div class="form-group m-0">
                        <?= Html::submitButton('<i class="fas fa-check"></i>&nbsp Complete', ['class' => 'btn btn-success']) ?>
                    </div>
                </div>


                <?php ActiveForm::end(); ?>

            </div>


        </div>

    </div>

</div>

<?php
$this->registerJs(<<<JS
    $(document).ready(function() {
        $('#amount_tendered').on('input', function() {
            var paymentAmount = parseFloat($('#payment_amount').val());
            var amountTendered = parseFloat($(this).val());
            var discountedPrice = parseFloat($('#discount').val());

            if (!isNaN(paymentAmount) && !isNaN(amountTendered)) {
                var totalAmount = paymentAmount + discountedPrice;
                if (amountTendered < totalAmount) {
                    // If amount tendered is less than total amount due
                    $('#change').val(''); // Clear change value
                    // You can show a message or take appropriate action here
                } else {
                    // Calculate change
                    var change = amountTendered - totalAmount;
                    $('#change').val(change.toFixed(2));
                }
            }
        });

        // Function to update discount based on selected promo
        function updateDiscount() {
            // Get the selected promo ID
            var promoId = $('#promo').val();
            
            // Make AJAX request to fetch promo discount
            $.ajax({
                url: '/bookings/promodiscount', // Update URL as needed
                method: 'GET',
                data: {promoId: promoId},
                success: function(response) {
                    // Calculate discounted amount
                    var paymentAmount = parseFloat($('#payment_amount').val());
                    var percentage = parseFloat(response);
                    var discountAmount = (percentage / 100) * paymentAmount;
                    var formattedDiscount = discountAmount === 0 ? '0.00' : '-' + discountAmount.toFixed(2);
        
                    $('#discount').val(formattedDiscount);
                    $('#amount_tendered').val('');
                    
                    var totalDue = paymentAmount - discountAmount;
                    $('#total_due').val(totalDue.toFixed(2));
                    $('#total-due').text(totalDue.toFixed(2));
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        
        // Listen for changes in the promo dropdown
        $('#promo').on('change', function() {
            // Update discount when dropdown selection changes
            updateDiscount();
        });
        
        // Trigger initial update when the page loads
        updateDiscount();
        
        
    });
JS
);
?>