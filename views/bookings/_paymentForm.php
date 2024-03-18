<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $paymentModel app\models\Payments */
/* @var $dataProvider app\models\BookingsServices */
/* @var $form yii\bootstrap4\ActiveForm */

$promos = $paymentModel->fetchAndMapData(\app\models\Promos::class, 'id', 'promo');
//Yii::info($promos, 'Promos Data');
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
                            <?= $form->field($paymentModel, 'payment_amount')->textInput(['readonly' => true])->label('Total Due') ?>
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
                            ['0' => 'None'] + $promos
                        ) ?>
                    </div>

                    <div class="col-md-4">
                        <?= $form->field($paymentModel, 'discount')->textInput(['readonly' => true]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'amount_tendered')->textInput(['type' => 'number']) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'change')->textInput(['readonly' => true]) ?>
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
    $('#paymentmodel-amount_tendered').on('input', function() {
        var paymentAmount = parseFloat($('#paymentmodel-payment_amount').val());
        var amountTendered = parseFloat($(this).val());

        if (!isNaN(paymentAmount) && !isNaN(amountTendered)) {
            var change = amountTendered - paymentAmount;
            $('#paymentmodel-change').val(change.toFixed(2));
        }
    });
JS
);

?>
