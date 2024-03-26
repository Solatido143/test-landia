<?php

/* @var $this yii\web\View */
/* @var $model app\models\SubProducts */
/* @var $modelInvUpdates app\models\InventoryUpdates */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update Sub Item: ' . $model->sub_products_name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = [
    'label' => isset($model->product_id) ? \app\models\Products::findOne($model->product_id)->product_name : '',
    'url' => ['view', 'id' => $model->product_id],
];
$this->params['breadcrumbs'][] = ['label' => $model->sub_products_name];
$this->params['breadcrumbs'][] = 'Update';


$mainProductList = $model->fetchAndMapData(\app\models\Products::class, 'id', 'product_name');
$update_status = $model->fetchAndMapData(\app\models\InventoryStatus::class, 'id', 'item_status');

$id = Yii::$app->request->get('id');
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="sub-products-form">
                                <?php $form = ActiveForm::begin(); ?>

                                <div class="row">

                                    <div class="col-md-8">
                                        <?= $form->field($model, 'product_id')->dropDownList($mainProductList, [
                                            'prompt' => '-- Select Main Product',
                                            'options' => [$id => ['selected' => true]]
                                        ])->label('Main Product') ?>
                                    </div>
                                    <div class="col-md-8">
                                        <?= $form->field($model, 'sub_products_name')->textInput(['maxlength' => true])->label('Sub Item Name') ?>
                                    </div>
                                    <div class="col-md-8">
                                    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'fk_item_status')->dropDownList(
                                            $update_status,
                                            ['prompt' => '- Select status -'])->label('Status')
                                        ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $form->field($model, 'new_stock_quantity')->textInput(['type' => 'number'])->label('Quantity') ?>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-success']) ?>
                                </div>

                                <?php ActiveForm::end(); ?>

                            </div>

                        </div>
                    </div>
                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
    </div>

</div>