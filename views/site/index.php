<?php

/* @var $dataProviders yii\data\ActiveDataProvider */
/* @var $totalBookingsCount int */
/* @var $completedBookingsCount int */
/* @var $cancelledBookingsCount int */

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
                            'title' => $totalBookingsCount,
                            'text' => 'Total Bookings',
                            'icon' => 'fas fa-calendar',
                            'theme' => 'success',
                            'options' => [
                                'class' => 'small-box bg-success',
                            ],
                            'linkUrl' => ['/bookings'],
                            'linkText' => 'More Info',
                        ]) ?>
                </div>
                <div class="col-lg-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => $completedBookingsCount,
                        'text' => 'Completed Bookings',
                        'icon' => 'fas fa-check',
                        'theme' => 'primary',
                        'options' => [
                            'class' => 'small-box bg-primary',
                        ],
                        'linkUrl' => ['/bookings', 'status' => 3],
                        'linkText' => 'More Info',
                    ]) ?>
                </div>
                <div class="col-lg-12">
                    <?= \hail812\adminlte\widgets\SmallBox::widget([
                        'title' => $cancelledBookingsCount,
                        'text' => 'Cancelled Bookings',
                        'icon' => 'fas fa-ban',
                        'theme' => 'danger',
                        'options' => [
                            'class' => 'small-box bg-danger',
                        ],
                        'linkUrl' => ['/bookings', 'status' => 4],
                        'linkText' => 'More Info',
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
                                    } elseif ($status == 3) {
                                        echo 'Complete';
                                    }
                                    ?>
                                </h5>
                                <a href="<?= Yii::$app->urlManager->createUrl(['bookings/index', 'status' => $status]) ?>" class="text-decoration-none">View all</a>
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
$payments = \app\models\Payments::find()->all();

// Initialize variables to find the latest month and year in payment dates
$latestMonth = null;
$latestYear = null;

foreach ($payments as $payment) {
    $paymentDate = $payment->payment_date;
    $paymentYear = (int) date('Y', strtotime($paymentDate));
    $paymentMonth = (int) date('m', strtotime($paymentDate));

    if ($latestYear === null || $latestYear < $paymentYear || ($latestYear == $paymentYear && $latestMonth < $paymentMonth)) {
        $latestYear = $paymentYear;
        $latestMonth = $paymentMonth;
    }
}

// Calculate start month and year for the last six months based on the latest month and year
$startMonth = $latestMonth - 5;
$startYear = $latestYear;
if ($startMonth <= 0) {
    $startMonth += 12;
    $startYear--;
}

// Calculate the range description
$startTimestamp = mktime(0, 0, 0, $startMonth, 1, $startYear);
$endTimestamp = mktime(0, 0, 0, $latestMonth, 1, $latestYear);
$startDateStr = date('F Y', $startTimestamp);
$endDateStr = date('F Y', $endTimestamp);
$rangeDescription = "$startDateStr to $endDateStr";

// Initialize arrays for xAxisCategories and salesData
$xAxisCategories = [];
$salesData = [0, 0, 0, 0, 0, 0];

// Calculate xAxisCategories and salesData for the last six months
for ($i = 0; $i < 6; $i++) {
    $currentMonth = $startMonth + $i;
    $currentYear = $startYear;

    if ($currentMonth > 12) {
        $currentMonth -= 12;
        $currentYear++;
    }

    // Calculate timestamp and add formatted date to xAxisCategories
    $timestamp = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
    $xAxisCategories[] = date('F Y', $timestamp);

    // Calculate the payment date range for this month
    $monthStart = date('Y-m-01', $timestamp);
    $monthEnd = date('Y-m-t', $timestamp);

    // Calculate the sum of payment_amount + discount for this month
    foreach ($payments as $payment) {
        $paymentDate = $payment->payment_date;
        if ($paymentDate >= $monthStart && $paymentDate <= $monthEnd) {
            $rowSum = $payment->payment_amount + $payment->discount;
            $salesData[$i] += $rowSum;
        }
    }
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