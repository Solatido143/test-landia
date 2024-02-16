<?php
$this->title = 'Nail Landia';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row mb-3">
<!--        <div class="col-lg-6 my-auto">-->
<!--            <div id="myCarousel" class="carousel slide mb-3 mb-lg-0" data-ride="carousel">-->
<!--                <div class="carousel-inner">-->
<!--                    <div class="carousel-item active">-->
<!--                        <img class="d-block w-100" src="https://via.placeholder.com/1280x720" alt="First slide">-->
<!--                    </div>-->
<!--                    <div class="carousel-item">-->
<!--                        <img class="d-block w-100" src="https://via.placeholder.com/1280x720" alt="Second slide">-->
<!--                    </div>-->
<!--                    <div class="carousel-item">-->
<!--                        <img class="d-block w-100" src="https://via.placeholder.com/1280x720" alt="Third slide">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">-->
<!--                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
<!--                    <span class="sr-only">Previous</span>-->
<!--                </a>-->
<!--                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">-->
<!--                    <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
<!--                    <span class="sr-only">Next</span>-->
<!--                </a>-->
<!--            </div>-->
<!--        </div>-->

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
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
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
    </div>
</div>
