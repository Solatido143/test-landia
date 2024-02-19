<?php
$this->title = 'Overview';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row mb-3">

        <div class="col-lg-8">

            <div class="row g-3 mb-3">
                <div class="d-lg-none">
                    <button type="button" class="btn btn-warning btn-block">
                        <i class="fas fa-plus"></i>
                        Add Reservation
                    </button>
                </div>

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
                            <form>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="button">Search</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Michael Johnson</td>
                                    <td>michael@example.com</td>
                                </tr>
                                </tbody>
                            </table>

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
                            <form>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="button">Search</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>John Doe</td>
                                    <td>john@example.com</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Michael Johnson</td>
                                    <td>michael@example.com</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col">
            <button type="button" class="btn btn-warning btn-block mb-3 d-none d-lg-block">
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
