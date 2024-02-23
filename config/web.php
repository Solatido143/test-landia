<?php

use yii\rest\UrlRule;
use yii\web\JsonParser;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
//        'view' => [
//            'theme' => [
//                'pathMap' => [
//                    '@app/views' => '@vendor/hail812/yii2-adminlte3/src/views'
//                ],
//            ],
//        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ZRvCDLtO-03SgGUlKRqDPABfE6ouO6sK',
            'parsers' => [
                'application/json' => JsonParser::class
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
//                api
                'product-list/products' => 'products-api/get-products',
                'product-list/create' => 'products-api/create-products',
                'product-list/view' => 'products-api/view-products',
                'product-list/update' => 'products-api/update-products',
                'product-list/delete' => 'products-api/delete-products',

                'user/view' => 'user/view-users',
                'user/all' => 'user/get-users',
                'user/create' => 'user/create-users',
                'user/update' => 'user/update-users',
                'user/delete' => 'user/delete-users',
                'user/user-login' => 'user/validate-login',
            ],
        ],
    ],
//    'as beforeRequest' => [  //if guest user access site so, redirect to login page.
//        'class' => 'yii\filters\AccessControl',
//        'rules' => [
//            [
////                controller actions
//                'actions' => ['login', 'error', 'register', 'forgot-password', 'change-password'],
//                'allow' => true,
//            ],
////            api controller actions
//            [
//                'actions' => ['login-user', 'attendance', 'get-preferences', 'save-location', 'admin-request', 'get-users', 'post-users'],
//                'allow' => true,
//            ],
////            controllers
//            [
//                'controllers' => ['email-report', 'tracker', 'employees-api'],
//                'allow' => true,
//            ],
//            [
//                'allow' => true,
//                'roles' => ['@'],
//            ],
//        ],
//    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

// config/main-local.php for advanced app
if (!YII_ENV_TEST) {
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [ // here
            'crud' => [ // generator name
                'class' => 'yii\gii\generators\crud\Generator', // generator class
                'templates' => [ // setting for our templates
                    'yii2-adminlte3' => '@vendor/hail812/yii2-adminlte3/src/gii/generators/crud/default' // template name => path to template
                ]
            ]
        ]
    ];
}

return $config;
