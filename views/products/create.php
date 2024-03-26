<?php

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = 'Create Products';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <div class="products-form">

                                <?php $form = ActiveForm::begin(); ?>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <?= $form->field($model, 'product_name')->textInput(['maxlength' => true]) ?>
                                            </div>
                                            <div class="col-md-6">
                                                <?= $form->field($model, 'stock_quantity')->textInput(['type' => 'number']) ?>
                                            </div>
                                            <div class="col-md-12">
                                                <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>
                                            </div>
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

        </div>

    </div>
    <!--.card-->
</div>