<?php

/* @var $this yii\web\View */
/* @var $model app\models\Attendances */

$this->title = 'Time Out';
$this->params['breadcrumbs'][] = ['label' => 'Attendance', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Time Out'];
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?=$this->render('_form', [
                        'model' => $model
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>