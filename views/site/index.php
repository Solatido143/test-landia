<?php
$this->title = 'Overview';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-lg-6">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '673',
                        'text' => 'Sales',
                        'icon' => 'fas fa-solid fa-certificate',
                        'theme' => 'success',
                    ]) ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '10',
                        'text' => 'Service',
                        'icon' => 'fas fa-solid fa-bell-concierge',
                        'theme' => 'primary',
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '542',
                        'text' => 'Total Service',
                        'icon' => 'fas fa-solid fa-receipt',
                    ]) ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '64',
                        'text' => 'Booking',
                        'icon' => 'fas fa-solid fa-hand-sparkles',
                        'theme' => 'warning',
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card text-center">
                <div class="card-header">
                    <ul class="nav nav-pills card-header-pills">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">Active</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Link</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body text-start">
                    <h5 class="card-title">Special title treatment</h5>
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card-body">
                <div class="services-box card border border-5 border-secondary text-center" style="">
                    <a href="#" class="text-decoration-none">
                        <div class="card-body py-5 services-body" style="">
                            <div class="card-img-top pt-3">
<!--                                            <img src="./pictures/bambanglogo.png" alt="ehe" height="100" width="100">-->
                            </div>
                            <h4 class="card-title"></h4>
                            <p class="card-text services-box-clamp"></p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
