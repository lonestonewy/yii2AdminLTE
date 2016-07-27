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

    public $depends = [];

    public $css = [
        'daterangepicker/daterangepicker.css',
        'datepicker/datepicker3.css',
        'iCheck/all.css',
        'timepicker/bootstrap-timepicker.min.css',
        'select2/select2.min.css',
    ];

    public $js = [
        'slimScroll/jquery.slimscroll.min.js',
        // 'sparkline/jquery.sparkline.min.js',
        'chartjs/Chart.min.js',
        'select2/select2.min.js',
        'input-mask/jquery.inputmask.js',
        'input-mask/jquery.inputmask.date.extensions.js',
        'input-mask/jquery.inputmask.extensions.js',
        'timepicker/bootstrap-timepicker.js',
        'daterangepicker/daterangepicker.js',
        'datepicker/bootstrap-datepicker.js',
        'slimScroll/jquery.slimscroll.min.js',
        'iCheck/icheck.min.js',
        'fastclick/fastclick.js',
    ];
}
