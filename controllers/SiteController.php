<?php

namespace app\controllers;

use app\models\Bookings;
use Yii;
use yii\data\ActiveDataProvider;
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
            4 => Bookings::find()->with('fkBookingStatus'),
        ];

        $currentDate = date('Y-m-d');

        // Set conditions for each query to filter by current date
        foreach ($queries as $status => $query) {
            $query->where(['fk_booking_status' => $status])
                ->andWhere(['>=', 'DATE(logged_time)', $currentDate])
                ->andWhere(['<', 'DATE(logged_time)', date('Y-m-d', strtotime($currentDate . ' +1 day'))]);
        }

        // Create data providers for each query
        $dataProviders = [];
        foreach ($queries as $status => $query) {
            $dataProviders[$status] = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => 5,
                ],
            ]);
        }

        // Pass the data providers to the view
        return $this->render('index', [
            'dataProviders' => $dataProviders,
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
//            Send notification messages
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

    public function actionSettings()
    {
        return $this->render('settings');
    }

}
