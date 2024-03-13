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
                            'text' => 'Total Bookings',
                            'icon' => 'fas fa-bell-concierge',
                            'theme' => 'success',
                        ]) ?>
                </div>
                <div class="col col-md-6 col-lg-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '10',
                        'text' => 'Completed Bookings',
                        'icon' => 'fas fa-bell-concierge',
                        'theme' => 'primary',
                    ]) ?>
                </div>
                <div class="col col-md-6 col-lg-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '10',
                        'text' => 'Cancelled Bookings',
                        'icon' => 'fas fa-bell-concierge',
                        'theme' => 'danger',
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="flex-grow-1">My Daily Activity</h5>
                            <a href="#" class="text-decoration-none text-nowrap">View all</a>
                        </div>
                        <div class="card-body" style="overflow-x: auto;">
                            <?php

                            use microinginer\dropDownActionColumn\DropDownActionColumn;
                            use scotthuangzl\googlechart\GoogleChart;
                            use yii\grid\GridView;

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
            </div>
        </div>



        <div class="col-lg-12">

            <div class="row g-3 mb-3">

                <div class="col-md-4">

                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="flex-grow-1">In queue</h5>
                            <a href="#" class="text-decoration-none">View all</a>
                        </div>
                        <div class="card-body">
                            <?= GridView::widget([
                                'dataProvider' => $inQueueDataProvider,
                                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                                'columns' => [
                                    [
                                        'attribute' => 'fk_customer',
                                        'label' => 'Customer',
                                        'value' => function($model){
                                            $customer = \app\models\Customers::findOne($model->fk_customer);
                                            return $customer->customer_name;
                                        }
                                    ],
                                    'schedule_time',
                                ],
                                'layout' => '{items}{pager}',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ]
                            ]); ?>
                            <figure class="highcharts-figure">
                                <div id="container"></div>
                                <p class="highcharts-description">
                                    Basic line chart showing trends in a dataset. This chart includes the
                                    <code>series-label</code> module, which adds a label to each line for
                                    enhanced readability.
                                </p>
                            </figure>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="flex-grow-1">On going</h5>
                            <a href="#" class="text-decoration-none">View all</a>
                        </div>
                        <div class="card-body">
                            <?= GridView::widget([
                                'dataProvider' => $onGoingDataProvider,
                                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                                'columns' => [
                                    [
                                        'attribute' => 'fk_customer',
                                        'label' => 'Customer',
                                        'value' => function($model){
                                            $customer = \app\models\Customers::findOne($model->fk_customer);
                                            return $customer->customer_name;
                                        }
                                    ],
                                    'schedule_time',
                                ],
                                'layout' => '{items}{pager}',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">

                    <div class="card">
                        <div class="card-header d-flex align-items-center">
                            <h5 class="flex-grow-1">Complete</h5>
                            <a href="#" class="text-decoration-none">View all</a>
                        </div>
                        <div class="card-body">
                            <?= GridView::widget([
                                'dataProvider' => $completeDataProvider,
                                'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                                'columns' => [
                                    [
                                        'attribute' => 'fk_customer',
                                        'label' => 'Customer',
                                        'value' => function($model){
                                            $customer = \app\models\Customers::findOne($model->fk_customer);
                                            return $customer->customer_name;
                                        }
                                    ],
                                    'schedule_time',
                                ],
                                'layout' => '{items}{pager}',
                                'pager' => [
                                    'class' => 'yii\bootstrap4\LinkPager',
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>
</div>

<?php
// Highcharts chart initialization script
$this->registerJs("
    Highcharts.chart('container', {
        title: {
            text: 'U.S Solar Employment Growth',
            align: 'left'
        },
        subtitle: {
            text: 'By Job Category. Source: <a href=\"https://irecusa.org/programs/solar-jobs-census/\" target=\"_blank\">IREC</a>.',
            align: 'left'
        },
        yAxis: {
            title: {
                text: 'Number of Employees'
            }
        },
        xAxis: {
            accessibility: {
                rangeDescription: 'Range: 2010 to 2020'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 2010
            }
        },
        series: [{
            name: 'Installation & Developers',
            data: [43934, 48656, 65165, 81827, 112143, 142383,
                171533, 165174, 155157, 161454, 154610]
        }, {
            name: 'Manufacturing',
            data: [24916, 37941, 29742, 29851, 32490, 30282,
                38121, 36885, 33726, 34243, 31050]
        }, {
            name: 'Sales & Distribution',
            data: [11744, 30000, 16005, 19771, 20185, 24377,
                32147, 30912, 29243, 29213, 25663]
        }, {
            name: 'Operations & Maintenance',
            data: [null, null, null, null, null, null, null,
                null, 11164, 11218, 10077]
        }, {
            name: 'Other',
            data: [21908, 5548, 8105, 11248, 8989, 11816, 18274,
                17300, 13053, 11906, 10073]
        }],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }
    });
");
?>