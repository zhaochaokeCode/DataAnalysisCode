<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',


    //更改默认控制器
    'defaultRoute' =>'index',

    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
//            'dsn' => 'mysql:host=116.62.100.98;dbname=data_analysis',
            'dsn' => 'mysql:host=127.0.0.1;dbname=data_analysis',
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
            "enableCsrfValidation"=>false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
            'timeout'=>3,
        ],
//        'log' => [
//            'traceLevel' => YII_DEBUG ? 3 : 0,
//            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                ],
//            ],
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'assetManager' => [
            'bundles' => [
                // 禁用 (bootstrap.css)
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ] ,
                // 禁用 JS (bootstrap.js)
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' =>[]
                ],
                // 禁用 JQuery (jquery.js)
                'yii\web\JqueryAsset' => [
                    'js' =>[]
                ],

                // 改变默认加载的jQuery版本
//                'yii\web\JqueryAsset' => [
//                    'sourcePath' => null,
//                    'basePath' => '@webroot',
//                    'baseUrl' => '@web',
//                    'js' => [
//                        'js' => [
//                            // 开发模式下不加载 .min压缩文件
//                            YII_ENV_DEV ? 'js/jquery-1.11.3.js' : 'js/jquery-1.11.3.min.js' ,
//                        ]
//                    ]
//                ],
            ] ,
        ] ,









    ],
    'params' => $params,
];
