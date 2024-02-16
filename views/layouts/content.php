<?php
/* @var $content string */

use yii\bootstrap4\Breadcrumbs;
use hail812\adminlte\widgets\Alert;

$success = Yii::$app->session->getFlash('success');
$error = Yii::$app->session->getFlash('error');
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <?php if ($success || $error) : ?>
                <?= Alert::widget([
                    'type' => $success ? 'success' : 'danger',
                    'title' => $success ? $success['title'] : $error['title'],
                    'body' => $success ? $success['body'] : $error['body'],
                ]) ?>
                <script>
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