<?php

use app\models\Employees;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Attendances */

$employee = \app\models\Employees::findOne(['id' => $model->fk_employee]);

$this->title = $employee->fname . " " . $employee->lname;
$this->params['breadcrumbs'][] = ['label' => 'Attendances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            [
                                'attribute' => 'fk_employee',
                                'label' => 'Employee',
                                'value' => function($model) {
                                    $employee = Employees::findOne($model->fk_employee);
                                    return $employee ? $employee->fname . " " . $employee->lname : null;
                                }
                            ],
                            'date',
                            'sign_in',
                            'sign_out',
                            [
                                'label' => 'Total Hours',
                                'value' => function($model) {
                                    if ($model->sign_in && $model->sign_out) {
                                        $signInTime = new DateTime($model->sign_in);
                                        $signOutTime = new DateTime($model->date . $model->sign_out);
                                        $interval = $signOutTime->diff($signInTime);

                                        $output = '';
                                        if ($interval->d > 0) {
                                            $output .= $interval->d . ' days ';
                                        }
                                        $output .= $interval->h . ' hours ';
                                        $output .= $interval->i . ' minutes';

                                        return $output;
                                    } else {
                                        return 'N/A';
                                    }
                                }
                            ],
                            'remarks:ntext',
                            //'sign_in_log',
                            //'sign_out_log',
                        ],
                    ]) ?>
                </div>
                <!--.col-md-12-->
            </div>
            <!--.row-->
        </div>
        <!--.card-body-->
    </div>
    <!--.card-->
</div>