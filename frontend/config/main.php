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
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],

            //'routes' => [
            //    array( //开发过程中所有日志直接页面打印，这样不需要登录服务器看日志了
            //        'class' => 'CWebLogRoute',
            //        'levels' => 'trace,info,profile,warning,error',
            //    ),
            //]

        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /* view.renderers use Smarty, but config in common/main.php */
        'view' => [
            'renderers' => [
                'tpl' => [
                    'imports' => frontend\controllers\BaseController::imports()
                    //'cachePath' => '@runtime/Smarty/cache',
                ],
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];
