<?php

namespace backend\assets;

use yii\web\View;
use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $jsOptions = ['position'=>View::POS_HEAD];
    public $css = [
        'css/site.css',
        'css/jasny-bootstrap.min.css',
    ];
    public $js = [
        'js/jasny-bootstrap.min.js',
        'js/app.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\widgets\ActiveFormAsset',
        'light\widgets\LockBsFormAsset',
        'light\widgets\SweetSubmitAsset',
        'backend\assets\AdminLteAsset',
        // 'backend\assets\CKFinderAsset',
        'backend\assets\BlueimpGalleryAsset',
    ];
}
