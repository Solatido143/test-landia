<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $services app\models\Services */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="bookings-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">

            <div class="row">
                <div class="col-md-6 text-sm">
                    <?= $form->field($model, 'booking_type')->dropdownList([ 'Walk-in' => 'Walk-in', 'Online' => 'Online', 'Call' => 'Call', ], ['prompt' => '- Select Booking Type -']) ?>
                </div>
                <div class="col-md-6 text-sm">
                    <?= $form->field($model, 'schedule_time')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 text-sm">
                    <?= $form->field($model, 'fk_customer')->textInput() ?>
                </div>
                <div class="col-md-6 text-sm d-flex align-items-center justify-content-center">
                    <h5>Total due: Php <span id="total-due"></span></h5>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 text-sm">
                    <?= $form->field($model, 'remarks')->textarea(['rows' => 4, 'placeholder' => 'Enter remarks here...']) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    <h3>Services</h3>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="form-group">
                        <?= Html::a('<i class="fas fa-plus"></i>&nbsp Add Service', ['service/create'], ['class' => 'btn btn-success']) ?>
                    </div>
                </div>
            </div>

            <?= \yii\grid\GridView::widget([
                'dataProvider' => new \yii\data\ArrayDataProvider([
                    'allModels' => $services,
                    'pagination' => [
                        'pageSize' => 10, // Set the page size to 10
                    ],
                ]),
                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                'tableOptions' => ["class" => "table table-striped table-bordered"],
                'layout' => "{items}\n{pager}",
                'pager' => [
                    'class' => \yii\widgets\LinkPager::class,
                    'options' => ['class' => 'pagination'],
                    'linkContainerOptions' => ['class' => 'page-item'],
                    'linkOptions' => ['class' => 'page-link'],
                    'disabledListItemSubTagOptions' => ['class' => 'page-link']
                ],
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

    <hr>

    <div class="row">
        <div class="col">
            <div class="form-group">
                <?= Html::submitButton('<i class="fas fa-forward-step"></i>&nbsp Proceed', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
        <div class="col">
            <div class="form-group text-end">
                <?= Html::a('<i class="fas fa-plus"></i>&nbsp Add Customer', ['/customers/create'], ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>




    <?php ActiveForm::end(); ?>

</div>

<?php
// Define a JavaScript block to handle checkbox changes
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
    });
});
JS
);
?>

