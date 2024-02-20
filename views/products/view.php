<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Products */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <?= Html::a('Update', ['update', 'product_id' => $model->product_id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::button('Back', ['class' => 'btn btn-danger', 'id' => 'backButton']) ?>
                    </p>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'product_id',
                            'name',
                            'description:ntext',
                            'price',
                            'stock_quantity',
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

<?php
$this->registerJs("
    $('#backButton').click(function() {
        window.location.href = '" . Yii::$app->urlManager->createUrl(['products/index']) . "'; // Redirect to index page
    });
");
?>