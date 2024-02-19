<?php
$this->title = 'Overview';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row mb-3">

        <div class="col-lg-8">

            <div class="row g-3 mb-3">

                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '10',
                        'text' => 'Service',
                        'icon' => 'fas fa-solid fa-bell-concierge',
                        'theme' => 'light',
                    ]) ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '542',
                        'text' => 'Total Service',
                        'icon' => 'fas fa-solid fa-receipt',
                        'theme' => 'light',
                    ]) ?>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '64',
                        'text' => 'Booking',
                        'icon' => 'fas fa-solid fa-hand-sparkles',
                        'theme' => 'light',
                    ]) ?>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="flex-grow-1">In queue</h5> <!-- Use flex-grow-1 to allow the title to grow and take up the remaining space -->
                            <a href="#" class="text-decoration-none">View all</a>
                        </div>

                        <div class="card-body">
                            <?php
                            // Example Yii2 ActiveForm for the search bar
                            use yii\widgets\ActiveForm;
                            use yii\helpers\Html;

                            // Start ActiveForm
                            $form = ActiveForm::begin([
                                'action' => ['index'],
                                'method' => 'get',
                                'options' => ['class' => 'form-inline'],
                            ]);
                            ?>

                            <?= $form->field($searchModel, 'search')->textInput(['class' => 'form-control mr-2', 'placeholder' => 'Search'])->label(false) ?>

                            <div class="form-group">
                                <?= Html::submitButton('search', ['class' => 'btn btn-primary']) ?>
                            </div>

                            <?php ActiveForm::end(); // End ActiveForm ?>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5>Payments</h5>
                            <a href="#" class="text-decoration-none ms-auto">View all</a>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">Card title</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col">
            <button type="button" class="btn btn-warning btn-block mb-3">
                <i class="fas fa-plus"></i>
                Add Reservation
            </button>

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5>Services</h5>
                    <a href="#" class="text-decoration-none ms-auto">View all</a>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5>Out of Stocks</h5>
                    <a href="#" class="text-decoration-none ms-auto">View all</a>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>

        </div>

    </div>
</div>
