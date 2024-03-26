<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\SubProducts */
/* @var $productmodel app\models\Products */


$this->title = 'Create Sub Item: ' . $productmodel->product_name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['/products']];
$this->params['breadcrumbs'][] = [
    'label' => $productmodel->product_name,
    'url' => ['view', 'id' => $productmodel->id],
];
$this->params['breadcrumbs'][] = $this->title;

$mainProducts = \app\models\Products::find()
    ->select(['id', 'product_name'])
    ->asArray()
    ->all();
$mainProductList = \yii\helpers\ArrayHelper::map($mainProducts, 'id', 'product_name');

$id = Yii::$app->request->get('id');
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="sub-products-form">
                                        <?php $form = ActiveForm::begin(); ?>

                                        <?= $form->field($model, 'product_id')->dropDownList($mainProductList, [
                                            'prompt' => '-- Select Main Product',
                                            'options' => [$id => ['selected' => true]]
                                        ])->label('Main Product') ?>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <?= $form->field($model, 'sub_products_name')->textInput(['maxlength' => true])->label('Sub Item Name') ?>

                                            </div>
                                            <div class="col-md-6">
                                                <?= $form->field($model, 'quantity')->textInput(['type' => 'number']) ?>

                                            </div>
                                        </div>
                                        <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>


                                        <div class="form-group">
                                            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
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
    </div>
</div>