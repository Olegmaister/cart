<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class ThreeDTourAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position' => \yii\web\View::POS_HEAD];
    public $css = [
//        'build/css/main.min.css',
    ];
    public $js = [
        'files/3d-tours/pano2vr_player.js',
        'files/3d-tours/skin.js',
        'files/3d-tours/webvr/three.min.js',
        'files/3d-tours/webvr/webvr-polyfill.min.js',
        //'build/js/landing.js'
        //'js/jquery.nicescroll.js',
        //'https://code.jquery.com/jquery-3.4.1.min.js',
        //'js/jquery-3.4.1.min.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset', // jQuery
        //'yii\bootstrap\BootstrapAsset',
    ];
}
