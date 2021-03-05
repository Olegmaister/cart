<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/order.css',
		'build/css/main.min.css',
        'css/site.css'
    ];
    public $js = [
        //'js/jquery.nicescroll.js',
        //'https://code.jquery.com/jquery-3.4.1.min.js',
        //'js/jquery-3.4.1.min.js',
		'build/js/main.min.js',
        'js/cart.js',
        'js/order.js',
        'js/order_drain.js',
        'js/other.js',
        'js/customer/signup.js'
    ];
    public $depends = [
        'yii\web\YiiAsset', // jQuery
        //'yii\bootstrap\BootstrapAsset',
    ];
}
