<?php
namespace backend\assets;

use yii\base\Exception;
use yii\web\AssetBundle;
use yii\web\View;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/dist';
    public $jsOptions = ['position'=>View::POS_HEAD];

    public $css = [
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
    ];

    public $depends = [
        'rmrevin\yii\fontawesome\NpmFreeAssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'backend\assets\AdminLtePluginAsset',
    ];

    public $js = [
        'js/adminlte.min.js',
        'js/demo.js',
    ];
}
