<?php
/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Login</p>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']) ?>

                    <?= $form->field($model,'username', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                        ->label(false)
                        ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

                    <?= $form->field($model, 'password', [
                        'options' => ['class' => 'form-group has-feedback'],
                        'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
                        'template' => '{beginWrapper}{input}{error}{endWrapper}',
                        'wrapperOptions' => ['class' => 'input-group mb-3']
                    ])
                        ->label(false)
                        ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>


                    <div class="row">
                        <div class="col-8">
                            <?= $form->field($model, 'rememberMe')->checkbox([
                                'template' => '<div class="icheck-primary">{input}{label}</div>',
                                'style' => 'position: static; margin-left: 0.25rem; margin-right: 0.25rem; ',
                                'labelOptions' => [
                                    'class' => '',
                                    'style' => 'font-weight: normal',
                                ],
                                'uncheck' => null,
                            ]) ?>

                        </div>
                        <div class="col-4">
                            <?= Html::submitButton('Sign In', ['class' => 'btn btn-primary btn-block']) ?>
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
                        <a href="forgot-password">Forgot password</a>
                    </p>
                    <p class="mb-0">
                        <a href="register" class="text-center">Register now!</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
</div>
