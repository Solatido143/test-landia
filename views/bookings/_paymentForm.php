<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $paymentModel app\models\Payments */
/* @var $dataProvider app\models\BookingsServices */
/* @var $form yii\bootstrap4\ActiveForm */

$promos = $paymentModel->fetchAndMapData(\app\models\Promos::class, 'id', 'promo');
?>

<div class="payment-form">

    <div class="container-fluid">

        <div class="row">
            <div class="col-md-6">
                <!--Bookings Services GridView-->
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
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
                        // Other columns if needed
                    ],
                ]);
                ?>

            </div>
            <div class="col-md-6">

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($paymentModel, 'fk_booking')->textInput()->input('hidden')->label(false) ?>

                <div class="row">
                    <div class="p-0">
                        <div class="col-md-6">
                            <?= $form->field($paymentModel, 'total_due')->textInput(['readonly' => true]) ?>
                        </div>
                    </div>


                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'fk_promo')->dropdownList($promos) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'payment_amount')->textInput() ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($paymentModel, 'change')->textInput() ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>


        </div>

    </div>

</div>

<?php

?>