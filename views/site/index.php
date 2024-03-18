<?php


/* @var $dataProviders yii\data\ActiveDataProvider */


use yii\grid\GridView;

$this->title = 'Overview';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <div class="row mb-3">
                <div class="col-lg-12">
                        <?= \hail812\adminlte\widgets\SmallBox::widget([
                            'title' => '0',
                            'text' => 'Total Bookings',
                            'icon' => 'fas fa-calendar',
                            'theme' => 'success',
                            'options' => [
                                'class' => 'small-box bg-success',
                            ],
                        ]) ?>
                </div>
                <div class="col-lg-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '0',
                        'text' => 'Completed Bookings',
                        'icon' => 'fas fa-check',
                        'theme' => 'primary',
                        'options' => [
                            'class' => 'small-box bg-primary',
                        ],
                    ]) ?>
                </div>
                <div class="col-lg-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => '0',
                        'text' => 'Cancelled Bookings',
                        'icon' => 'fas fa-cancel',
                        'theme' => 'danger',
                        'options' => [
                            'class' => 'small-box bg-danger',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="row">

                <div class="col-md-12">
                    <div class="card mb-0">
                        <div class="card-body" style="overflow-x: auto;">
                            <figure class="highcharts-figure">
                                <div id="chat-container"></div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="row g-3 mb-3">
                <?php foreach ($dataProviders as $status => $dataProvider): ?>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header d-flex align-items-center">
                                <h5 class="flex-grow-1">
                                    <?php
                                    if ($status == 1) {
                                        echo 'In queue';
                                    } elseif ($status == 2) {
                                        echo 'On going';
                                    } elseif ($status == 4) {
                                        echo 'Complete';
                                    }
                                    ?>
                                </h5>
                                <a href="bookings" class="text-decoration-none">View all</a>
                            </div>
                            <div class="card-body">
                                <?= GridView::widget([
                                    'dataProvider' => $dataProvider,
                                    'options' => ['style' => 'overflow: auto; word-wrap: break-word; width: 100%'],
                                    'tableOptions' => ["class" => "table table-striped table-bordered text-nowrap"],
                                    'columns' => [
                                        [
                                            'attribute' => 'fk_customer',
                                            'label' => 'Customer',
                                            'value' => function ($model) {
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
                <?php endforeach; ?>
            </div>
        </div>


    </div>
</div>

<?php
// Calculate the current month and year
$currentMonth = date('n');
$currentYear = date('Y');

// Calculate the start month and year for the xAxis
$startMonth = $currentMonth - 5; // 6 months ago
$startYear = $currentYear;
if ($startMonth <= 0) {
    $startMonth += 12;
    $startYear--;
}

// Define the range description for accessibility
$rangeDescription = date('F Y', mktime(0, 0, 0, $startMonth, 1, $startYear)) . ' to ' . date('F Y');

// Initialize arrays to store xAxis categories and sales data
$xAxisCategories = [];
$salesData = [];

// Loop through the last 6 months and populate xAxis categories and sales data
for ($i = 0; $i < 6; $i++) {
    // Calculate month and year for the current iteration
    $month = ($startMonth + $i) % 12;
    if ($month == 0) $month = 12; // January is represented by 12 in date()
    $year = $startYear + floor(($startMonth + $i - 1) / 12);

    // Add the month and year to the xAxis categories
    $xAxisCategories[] = date('F Y', mktime(0, 0, 0, $month, 1, $year));

    // Generate a random sales value (replace this with your actual sales data retrieval logic)
    $salesValue = 0;

    // Add the sales value to the sales data array
    $salesData[] = $salesValue;
}

// Highcharts chart initialization script with dynamic data
$this->registerJs("
    Highcharts.chart('chat-container', {
        title: {
            text: 'Sales Report ($rangeDescription)',
            align: 'center'
        },
        yAxis: {
            title: {
                text: 'Total Sales'
            }
        },
        xAxis: {
            accessibility: {
                rangeDescription: '" . $rangeDescription . "'
            },
            categories: " . json_encode($xAxisCategories) . "
        },
        legend: {
            layout: 'horizontal',
            align: 'center',
            horizontalAlign: 'middle'
        },
        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                }
            }
        },
        series: [{
            name: 'Sales',
            data: " . json_encode($salesData) . "
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