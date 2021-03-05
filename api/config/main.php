<?php

use common\entities\Customer;
use frontend\components\LangUrlManager;


$params = array_merge(
    require __DIR__ . '/../../api/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php'
   // require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'cookieValidationKey' => $params['cookieDomain']
        ],
        'user' => [
            'identityClass' => Customer::class,
            'enableAutoLogin' => true,
//            'identityCookie' => [
//                'name' => '_identity',
//                'domain' => $params['cookieDomain'],
//                'httpOnly' => true
//            ],
        ],
//        'session' => [
//            // this is the name of the session cookie used for login on the frontend
//            'name' => 'session',
//            'cookieParams' => [
//                'domain' => $params['cookieDomain'],
//                'httpOnly' => true
//            ]
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'useStrictParsing' => true,
            'class' => LangUrlManager::class,
            'rules' => require __DIR__ . '/url-list.php',
        ],

    ],
    'params' => $params,
];
