<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/sweetalert.css',
    ];
    public $js = [
        'js/sweetalert.min.js',
        'js/jasny-bootstrap.min.js',
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\widgets\ActiveFormAsset',
        'light\widgets\LockBsFormAsset',
        'backend\assets\AdminLteAsset',
        // 'backend\assets\CKFinderAsset',
    ];
}
