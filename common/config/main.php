<?php

use common\bootstrap\SetUp;
use common\components\SaDbTarget;
use yii\caching\FileCache;
use yii\rbac\DbManager;
use yii\swiftmailer\Mailer;

return [
    'name' => 'PROF1 Group®',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@host'=> 'https://dev.p1gtac.com',
        '@staticRoot'=> dirname(__DIR__, 2) . '/frontend/web/images',
        '@static'=> '@host/frontend/web/images'
    ],
    'bootstrap' => [
        SetUp::class,
        'log'
    ],

    'vendorPath' => dirname(__DIR__, 2) . '/vendor',
    'components' => [
        'cache' => [
            'class' => FileCache::class,
        ],

        'authManager' => [
            'class' => DbManager::class
        ],
        'assetManager' => [
            'appendTimestamp' => true,
        ],
        'mailer' => [
            'class' => Mailer::class,
//            'useFileTransport' => false,
        ],

        /*'redis' => [
            'class' => 'yii\redis\Connection',
           #'hostname' => 'localhost',
           #'port' => 6379,
	        'unixSocket' => '/home/rgo/.system/redis.sock',
            'database' => 0,
        ],*/
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'flushInterval' => 1,
            'targets' => [
                [
                    'class' => SaDbTarget::class,
                    'levels' => ['error', 'warning'],
                    'logVars' => [],
                    'exportInterval' => 1,
                ]
            ],
        ],
        'captcha' => [
            'name'    => 'captcha',
            'class'   => 'szaboolcs\recaptcha\InvisibleRecaptcha',
            'siteKey' => '6Le-H-oZAAAAAEPnkDZx-6Ig3AXHmNV83V6pgQXR',
            'secret'  => '6Le-H-oZAAAAAJyd1TpIqcchwutR6luaoFunVy1q'
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => \yii\i18n\PhpMessageSource::class,
                    'basePath' => '@frontend/messages',
                ],
            ],
        ],
    ],
];
