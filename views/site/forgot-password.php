<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\RegisterForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Password Reset';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-5">
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Forgot Password</p>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

                    <?= $form->field($model, 'email', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                        ->label(false)
                        ->passwordInput(['placeholder' => $model->getAttributeLabel('reset_password')]) ?>

                    <div class="row ">
                        <div class="col-6">
                            <?= Html::submitButton('Password Reset', [
                                    'style' => 'margin-bottom: 1.25rem; white-space: nowrap;',
                                    'class' => 'btn btn-danger btn-block']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <p class="mb-0">
                        <a href="login" class="text-center">Login instead</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
</div>
