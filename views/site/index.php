<?php
$this->title = 'Overview';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <div class="row g-3">
                <div class="col-12 d-lg-none">
                    <button type="button" class="btn btn-success btn-block">
                        <i class="fas fa-plus"></i>
                        Add Reservation
                    </button>
                </div>
                <div class="col col-md-6 col-lg-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '10',
                        'text' => 'Service',
                        'icon' => 'fas fa-solid fa-bell-concierge',
                        'theme' => 'light',
                    ]) ?>
                </div>
                <div class="col col-md-6 col-lg-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '10',
                        'text' => 'Service',
                        'icon' => 'fas fa-solid fa-bell-concierge',
                        'theme' => 'light',
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row">

                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="flex-grow-1">My Daily Activity</h5>
                            <a href="#" class="text-decoration-none text-nowrap">View all</a>
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <?php
                            use scotthuangzl\googlechart\GoogleChart;

                            echo GoogleChart::widget([
                                'visualization' => 'LineChart',
                                'data' => [
                                    ['Task', 'Hours per Day'],
                                    ['Work', 11],
                                    ['Eat', 2],
                                    ['Commute', 2],
                                    ['Watch TV', 2],
                                    ['Sleep', 7]
                                ],
                                'options' => [
                                    'title' => '',
                                    'legend' => ['position' => 'top'],
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="flex-grow-1">Performance</h5>
                            <a href="#" class="text-decoration-none ms-auto text-nowrap">View all</a>
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <?php
                            echo GoogleChart::widget([
                                'visualization' => 'LineChart',
                                'data' => [
                                    ['Year', 'Sales', 'Expenses'],
                                    ['2004', 1000, 400],
                                    ['2005', 1170, 460],
                                    ['2006', 660, 1120],
                                    ['2007', 1030, 540],
                                    ['2008', 1030, 540],
                                ],
                                'options' => [
                                    'curveType' => 'function',
                                    'legend' => ['position' => 'top'],
                                ]
                            ]);
                            ?>
                        </div>

                    </div>
                </div>

            </div>
        </div>

        <div class="col-lg-8">
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
                            <div class="table-responsive">
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

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="flex-grow-1">Payments</h5>
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
                            <div class="table-responsive">
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

        </div>

        <div class="col">
            <button type="button" class="btn btn-success btn-block mb-3 d-none d-lg-block">
                <i class="fas fa-plus"></i>
                Add Reservation
            </button>

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="flex-grow-1">Services</h5>
                    <a href="#" class="text-decoration-none ms-auto">View all</a>
                </div>

                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h5 class="flex-grow-1">Out of Stocks</h5>
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
