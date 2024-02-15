<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\RegisterForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Signup';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Register</p>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

                    <?= $form->field($model,'username', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

                    <?= $form->field($model, 'new_password', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                        ->label(false)
                        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

                    <?= $form->field($model, 'confirm_password', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                        ->label(false)
                        ->passwordInput(['placeholder' => $model->getAttributeLabel('confirm_password')]) ?>


                    <div class="row">
                        <div class="col-4">
                            <?= Html::submitButton('Sign In', [
                                    'style' => 'margin-bottom: 1.25rem;',
                                    'class' => 'btn btn-danger btn-block']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>

                    <!--        <div class="social-auth-links text-center mb-3">-->
                    <!--            <p>- OR -</p>-->
                    <!--            <a href="#" class="btn btn-block btn-primary">-->
                    <!--                <i class="fab fa-facebook mr-2"></i> Sign in using Facebook-->
                    <!--            </a>-->
                    <!--            <a href="#" class="btn btn-block btn-danger">-->
                    <!--                <i class="fab fa-google-plus mr-2"></i> Sign in using Google+-->
                    <!--            </a>-->
                    <!--        </div>-->
                    <!-- /.social-auth-links -->

                    <p class="mb-1">
                        <a href="forgotpassword">I forgot my password</a>
                    </p>
                    <p class="mb-0">
                        <a href="login" class="text-center">Login here!</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
</div>
