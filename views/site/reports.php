<?php

/** @var $paymentModel app\models\Payments  */
/** @var $form yii\bootstrap4\ActiveForm $form */
/** @var $this yii\web\View $this */

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use yii\bootstrap4\Html;
use yii\bootstrap4\ActiveForm;
use yii\data\ArrayDataProvider;

$this->title = 'Reports';
$this->params['breadcrumbs'] = [['label' => $this->title]];


$dataProvider = new ArrayDataProvider(['allModels' => [
    ['id' => '10032460001', 'fruit' => 'Apples', 'quantity' => '100', 'value' => 213288.32],
    ['id' => '10032460002', 'fruit' => 'Oranges', 'quantity' => '60', 'value' => 84343.68],
    ['id' => '10032460003', 'fruit' => 'Bananas', 'quantity' => '160', 'value' => 49343.65],
    ['id' => '10032460004', 'fruit' => 'Pineapples', 'quantity' => '90', 'value' => 72631.02],
    ['id' => '10032460005', 'fruit' => 'Grapes', 'quantity' => '290', 'value' => 627653.65],
]]);
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
                        'columns' => [

                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_CSV => false,
                            ExportMenu::FORMAT_PDF => false,
                            ExportMenu::FORMAT_EXCEL => false,
                        ],
                        'asDropdown' => false,
                        'dropdownOptions' => [
                            'label' => 'Export All',
                            'class' => 'btn btn-outline-secondary btn-default'
                        ]
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Inventory Report</h5>
                </div>
                <div class="card-body">
                    <?= ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [

                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_CSV => false,
                            ExportMenu::FORMAT_PDF => false,
                            ExportMenu::FORMAT_EXCEL => false,
                        ],
                        'asDropdown' => false,
                        'dropdownOptions' => [
                            'label' => 'Export All',
                            'class' => 'btn btn-outline-secondary btn-default'
                        ]
                    ])
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5>Inventory Update</h5>
                </div>
                <div class="card-body">
                    <?= ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => [

                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_HTML => false,
                            ExportMenu::FORMAT_CSV => false,
                            ExportMenu::FORMAT_PDF => false,
                            ExportMenu::FORMAT_EXCEL => false,
                        ],
                        'asDropdown' => false,
                        'dropdownOptions' => [
                            'label' => 'Export All',
                            'class' => 'btn btn-outline-secondary btn-default'
                        ]
                    ])
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
