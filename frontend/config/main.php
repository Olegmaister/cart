<?php

use common\entities\Customer;
use frontend\components\LangRequest;
use frontend\components\LangUrlManager;
use yii\authclient\clients\Facebook;
use yii\authclient\clients\Google;
use yii\authclient\Collection;
use yii\i18n\PhpMessageSource;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'csrfParam' => '_csrf-frontend',
            'baseUrl' => '',
            'class' => LangRequest::class,
            'cookieValidationKey' => $params['cookieDomain']
        ],
        'user' => [
            'identityClass' => Customer::class,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity',
                'domain' => $params['cookieDomain'],
                'httpOnly' => true
            ],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'session',
            'cookieParams' => [
                'domain' => $params['cookieDomain'],
                'httpOnly' => true
            ]
        ],
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
        'authClientCollection' => [
            'class' => Collection::class,
            'clients' => [
                'google' => [
                    'class' => Google::class,
                    'clientId' => '468781370477-vk2b1l8dcfkels73q73cdlc238phg6b8.apps.googleusercontent.com',
                    'clientSecret' => '7F_T72uISuShMuQsEEHWfPrI',
                    'returnUrl' => 'https://dev.p1gtac.com/customer/network/auth?authclient=google'
                ],
                'facebook' => [
                    'class' => Facebook::class,
                    'clientId' => '2799034640350359',
                    'clientSecret' => '84d0cc6df72c39f528edbd26775ac057',
                    'returnUrl' => 'https://dev.p1gtac.com/customer/network/auth?authclient=facebook'
                ],
            ],
        ],
        'language' => 'ru-RU',
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@frontend/messages',
                    'sourceLanguage' => 'en',
                    'fileMap' => [
                        //'app' => 'app.php',
                        //'app/error' => 'error.php',
                    ],
                ],
                'yii*' => [
                    'class' => PhpMessageSource::class,
                    'basePath' => '@frontend/messages',
                    'fileMap' => [
                        'yii' => 'app.php',
                    ],
                ],
            ],
        ],
    ],
    'params' => $params,
];
