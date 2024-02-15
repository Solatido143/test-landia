<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use hail812\adminlte\widgets\Alert;

$title = Yii::$app->session->getFlash('registeredUser_success_title');
$body = Yii::$app->session->getFlash('registeredUser_success_body');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <div class="content-header">
        <div class="container-fluid">
            <?php if ($title && $body): ?>
            <?= Alert::widget([
                'type' => 'success',
                'title' => $title,
                'body' => $body,
            ]) ?>

            <script>
                // Function to hide the alert after 3 seconds
                setTimeout(function(){
                    $('.alert').fadeOut('slow');
                }, 3000); // 3000 milliseconds = 3 seconds
            </script>
            <?php endif; ?>
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php
                        if (!is_null($this->title)) {
                            echo \yii\helpers\Html::encode($this->title);
                        } else {
                            echo \yii\helpers\Inflector::camelize($this->context->id);
                        }
                        ?>
                    </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <?php
                    echo Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                        'options' => [
                            'class' => 'breadcrumb float-sm-right'
                        ]
                    ]);
                    ?>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <?= $content ?><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>