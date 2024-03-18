<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $paymentModel app\models\Payments */
/* @var $dataProvider app\models\BookingsServices */
/* @var $form yii\bootstrap4\ActiveForm */

// Fetch promos data
$promos = $paymentModel->fetchAndMapData(\app\models\Promos::class, 'id', 'promo');

// Initialize dropdown list options with 'None'
$promosOption = ['0' => 'None'];

// Check if $promos contains valid data
if ($promos) {
    // Iterate over each promo and construct the option label
    foreach ($promos as $promoId => $promoName) {
        // You might need to retrieve the percentage separately based on your model structure
        // Assuming you have a method to get percentage, replace $promo->percentage with the appropriate call
        $percentage = \app\models\Promos::findOne($promoId)->percentage;

        // Construct the option label with promo name and percentage
        $label = $promoName . ' (' . $percentage . '%)';

        // Add the option to the array with promo ID as the key
        $promosOption[$promoId] = $label;
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
                            <?= $form->field($paymentModel, 'payment_amount')->textInput(['readonly' => true, 'id' => 'payment_amount'])->label('Total Due') ?>
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
                        <?= $form->field($paymentModel, 'fk_promo')->dropdownList(
                            $promosOption,
                            ['id' => 'fk_promo']
                        ) ?>
                    </div>


                    <div class="col-md-4">
                        <?= $form->field($paymentModel, 'discount')->textInput(['readonly' => true, 'type' => 'number', 'id' => 'discount']) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'amount_tendered')->textInput(['type' => 'number', 'id' => 'amount_tendered']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'change')->textInput(['readonly' => true, 'id' => 'change']) ?>
                    </div>

                </div>

                <hr>

                <div class="form-group text-end">
                    <?= Html::submitButton('<i class="fas fa-check"></i>&nbsp Complete', ['class' => 'btn btn-success']) ?>
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

            if (!isNaN(paymentAmount) && !isNaN(amountTendered)) {
                var change = amountTendered - paymentAmount;
                $('#change').val(change.toFixed(2));
            }
        });

        // Function to update discount based on selected promo
        function updateDiscount() {
            // Get the selected promo ID
            var promoId = $('#fk_promo').val();
            
            // Make AJAX request to fetch promo discount
            $.ajax({
                url: '/bookings/promodiscount', // Update URL as needed
                method: 'GET',
                data: {promoId: promoId},
                success: function(response) {
                    // Update discount field with fetched discount value
                    $('#discount').val(response);
                },
                error: function(xhr, status, error) {
                    // Handle error if needed
                    console.error(xhr.responseText);
                }
            });
        }
        
        // Listen for changes in the fk_promo dropdown
        $('#fk_promo').on('change', function() {
            // Update discount when dropdown selection changes
            updateDiscount();
        });
        
        // Trigger initial update when the page loads
        updateDiscount();
    });
JS
);
?>