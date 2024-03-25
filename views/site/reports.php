<?php

/* @var $paymentModel app\models\Payments  */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $this yii\web\View */
/* @var $todayDate string */
/* @var $exportConfig array */

use kartik\export\ExportMenu;

$this->title = 'Reports';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Sales</h5>
                </div>
                <div class="card-body">
                    <?= ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'exportConfig' => $exportConfig,
                        'asDropdown' => false ,
                        'filename' => 'Sales Report - ' . $todayDate,
                        'headerStyleOptions' => ['class' => 'bg-blue']
                    ])
                    ?>
                </div>
            </div>
        </div>

<!--        <div class="col-md-4">-->
<!--            <div class="card">-->
<!--                <div class="card-header">-->
<!--                    <h5>Inventory Report</h5>-->
<!--                </div>-->
<!--                <div class="card-body">-->
<!--                    --><?php //= ExportMenu::widget([
//                        'dataProvider' => new ArrayDataProvider(['allModels' => [
//                            ['id' => '10032460001', 'fruit' => 'Apples', 'quantity' => '100', 'value' => 213288.32],
//                            ['id' => '10032460002', 'fruit' => 'Oranges', 'quantity' => '60', 'value' => 84343.68],
//                            ['id' => '10032460003', 'fruit' => 'Bananas', 'quantity' => '160', 'value' => 49343.65],
//                            ['id' => '10032460004', 'fruit' => 'Pineapples', 'quantity' => '90', 'value' => 72631.02],
//                            ['id' => '10032460005', 'fruit' => 'Grapes', 'quantity' => '290', 'value' => 627653.65],
//                        ]]),
//                        'columns' => [
//
//                        ],
//                        'exportConfig' => [
//                            ExportMenu::FORMAT_TEXT => false,
//                            ExportMenu::FORMAT_HTML => false,
//                            ExportMenu::FORMAT_CSV => false,
//                            ExportMenu::FORMAT_PDF => false,
//                            ExportMenu::FORMAT_EXCEL => false,
//                        ],
//                        'asDropdown' => false,
//                        'dropdownOptions' => [
//                            'label' => 'Export All',
//                            'class' => 'btn btn-outline-secondary btn-default'
//                        ]
//                    ])
//                    ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-md-4">-->
<!--            <div class="card">-->
<!--                <div class="card-header">-->
<!--                    <h5>Inventory Update</h5>-->
<!--                </div>-->
<!--                <div class="card-body">-->
<!--                    --><?php //= ExportMenu::widget([
//                        'dataProvider' => new ArrayDataProvider(['allModels' => [
//                            ['id' => '10032460001', 'fruit' => 'Apples', 'quantity' => '100', 'value' => 213288.32],
//                            ['id' => '10032460002', 'fruit' => 'Oranges', 'quantity' => '60', 'value' => 84343.68],
//                            ['id' => '10032460003', 'fruit' => 'Bananas', 'quantity' => '160', 'value' => 49343.65],
//                            ['id' => '10032460004', 'fruit' => 'Pineapples', 'quantity' => '90', 'value' => 72631.02],
//                            ['id' => '10032460005', 'fruit' => 'Grapes', 'quantity' => '290', 'value' => 627653.65],
//                        ]]),
//                        'columns' => [
//
//                        ],
//                        'exportConfig' => [
//                            ExportMenu::FORMAT_TEXT => false,
//                            ExportMenu::FORMAT_HTML => false,
//                            ExportMenu::FORMAT_CSV => false,
//                            ExportMenu::FORMAT_PDF => false,
//                            ExportMenu::FORMAT_EXCEL => false,
//                        ],
//                        'asDropdown' => false,
//                        'dropdownOptions' => [
//                            'label' => 'Export All',
//                            'class' => 'btn btn-outline-secondary btn-default'
//                        ]
//                    ])
//                    ?>
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>
