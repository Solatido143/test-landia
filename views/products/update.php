<?php

/* @var $this yii\web\View */
/* @var $model app\models\Products */
/* @var $inventory_update app\models\InventoryUpdates */

use app\models\SubProducts;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Update Product: ' . $model->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';

$update_status = $model->fetchAndMapData(\app\models\InventoryStatus::class, 'id', 'item_status');

$has_sub_item = SubProducts::find()
    ->where(['product_id' => $model->id])
    ->asArray()
    ->all();
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="products-form">

                                <?php $form = ActiveForm::begin(); ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">


                                            <div class="col-md-6">
                                                <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="col-md-8">
                                                <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
                                            </div>
                                            <?php if(empty($has_sub_item)) : ?>
                                                <div class="col-md-6">
                                                    <?= $form->field($model, 'fk_item_status')->dropDownList(
                                                        $update_status,
                                                        ['prompt' => '- Select status -'])->label('Status')
                                                    ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <?= $form->field($model, 'new_stock_quantity')->textInput(['type' => 'number'])->label('Quantity') ?>
                                                </div>
                                            <?php endif ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <?= Html::a('<i class="fa fa-arrow-left"></i>&nbsp Back',Yii::$app->request->referrer ?: Yii::$app->homeUrl, ['class' => 'btn btn-secondary']) ?>
                                    <?= Html::submitButton('<i class="fa fa-save"></i>&nbsp Save', ['class' => 'btn btn-success']) ?>
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