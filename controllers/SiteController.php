<?php

namespace app\controllers;

use app\models\Bookings;
use app\models\Payments;
use kartik\export\ExportMenu;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use app\models\LoginForm;
use app\models\RegisterForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        // Define queries for each status
        $queries = [
            1 => Bookings::find()->with('fkBookingStatus'),
            2 => Bookings::find()->with('fkBookingStatus'),
            3 => Bookings::find()->with('fkBookingStatus'),
        ];

        $currentDate = date('Y-m-d');

        foreach ($queries as $status => $query) {
            $query->where(['fk_booking_status' => $status])
                ->andWhere(['>=', 'DATE(logged_time)', $currentDate])
                ->andWhere(['<', 'DATE(logged_time)', date('Y-m-d', strtotime($currentDate . ' +1 day'))]);
        }

        $dataProviders = [];
        foreach ($queries as $status => $query) {
            $dataProviders[$status] = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
        }

        // Calculate total bookings count
        $totalBookingsCount = 0;
        foreach ($dataProviders as $dataProvider) {
            $totalBookingsCount += $dataProvider->getTotalCount();
        }

        // Query to count completed and cancelled bookings for today
        $todayDate = date('Y-m-d');
        $todayStart = $todayDate . ' 00:00:00';
        $todayEnd = $todayDate . ' 23:59:59';

        $bookingsCounts = Bookings::find()
            ->select([
                'completedBookingsCount' => 'COUNT(CASE WHEN fk_booking_status = 3 THEN 1 END)',
                'cancelledBookingsCount' => 'COUNT(CASE WHEN fk_booking_status = 4 THEN 1 END)'
            ])
            ->andWhere(['between', 'schedule_time', $todayStart, $todayEnd])
            ->asArray()
            ->one();

        $completedBookingsCount = $bookingsCounts['completedBookingsCount'];
        $cancelledBookingsCount = $bookingsCounts['cancelledBookingsCount'];

        // Pass the data providers to the view
        return $this->render('index', [
            'dataProviders' => $dataProviders,

            'totalBookingsCount' => $totalBookingsCount,
            'completedBookingsCount' => $completedBookingsCount,
            'cancelledBookingsCount' => $cancelledBookingsCount,
        ]);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->session->setFlash('success', [
                'title' => 'Yay!',
                'body' => 'Login successful.',
            ]);

            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('success', [
                'title' => 'Yay!',
                'body' => 'Registration successful.',
            ]);
            return $this->redirect(['site/login']);
        }

        $model->password = '';
        $model->confirmPassword = '';
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout(); // Logs out the currently logged in user.
        Yii::$app->session->setFlash('success', [
            'title' => 'Owmen!',
            'body' => 'Logout successful.',
        ]);
        return $this->redirect(['/site/login']); // Redirects the user to the login page after logout.
    }

    public function actionReports()
    {
        date_default_timezone_set('Asia/Manila');

        // Fetching payments data with related models if needed
        $payments = Payments::find()->all();

        // Transforming payments data to match the desired format and calculate totals
        $totalSales = 0;
        $totalDiscounts = 0;
        $exportData = [];
        foreach ($payments as $payment) {
            $customerName = $payment->fkBooking->fkCustomer->customer_name;

            // Increment total sales and total discounts
            $totalSales += $payment->payment_amount;
            $totalDiscounts += $payment->discount;

            $exportData[] = [
                'Customer Name' => $customerName,
                'Date' => date('Y-m-d', strtotime($payment->payment_date)),
                'Availed Services' => '',
                'Total Discount' => $payment->discount,
                'Total Sales' => $payment->payment_amount,
                'Grand Total' => '',
            ];
        }

        $difference = $totalSales + $totalDiscounts;

        // Add totals row to export data
        $exportData[] = [
            'Customer Name' => 'Total',
            'Date' => '',
            'Availed Services' => '',
            'Total Discount' => $totalDiscounts,
            'Total Sales' => $totalSales,
            'Grand Total' => $difference,
        ];

        // Creating the data provider
        $dataProvider = new ArrayDataProvider([
            'allModels' => $exportData,
        ]);

        // Configuring export menu
        $exportConfig = [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_CSV => false,
            ExportMenu::FORMAT_PDF => false,
            ExportMenu::FORMAT_EXCEL => false,
            ExportMenu::FORMAT_EXCEL_X => [
                'columns' => [
                    'Customer Name',
                    'Date',
                    'Availed Services',
                    'Total Discount',
                    'Total Sales',
                ],
            ],
        ];

        $todayDate = date('Y-m-d');

        return $this->render('reports', [
            'dataProvider' => $dataProvider,
            'exportConfig' => $exportConfig,
            'todayDate' => $todayDate,
        ]);
    }

}
