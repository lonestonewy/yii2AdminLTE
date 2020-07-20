<?php
namespace backend\assets;

use yii\base\Exception;
use yii\web\AssetBundle;

/**
 * AdminLte AssetBundle
 * @since 0.1
 */
class AdminLtePluginAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins';
    public $css = [
        'timepicker/bootstrap-timepicker.min.css',
        'iCheck/minimal/_all.css',
    ];

    public $js = [
        'input-mask/jquery.inputmask.js',
        'input-mask/jquery.inputmask.date.extensions.js',
        'input-mask/jquery.inputmask.extensions.js',
        'timepicker/bootstrap-timepicker.js',
        'iCheck/icheck.min.js',
        // 'fastclick/fastclick.js',
    ];
}
