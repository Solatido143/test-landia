<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Bookings */
/* @var $services app\models\Services[] */

$this->title = 'Create Bookings';
$this->params['breadcrumbs'][] = ['label' => 'Bookings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?=$this->render('_form', [
                        'model' => $model,
                        'services' => $services,
                    ]) ?>
                </div>
            </div>
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>