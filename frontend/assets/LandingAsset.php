<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class LandingAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
		'build/css/landing.min.css',
    ];
    public $js = [
        'build/js/landing.js'
        //'js/jquery.nicescroll.js',
        //'https://code.jquery.com/jquery-3.4.1.min.js',
        //'js/jquery-3.4.1.min.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset', // jQuery
        //'yii\bootstrap\BootstrapAsset',
    ];
}
