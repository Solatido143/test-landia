<?php

/* @var $this yii\web\View */
/* @var $model app\models\Employees */

$this->title = 'Update Employee: ' . $model->fname . ' ' . $model->lname;
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->employee_id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
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
    </div>

</div>