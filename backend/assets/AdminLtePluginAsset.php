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
        'select2/select2.min.css',

    ];

    public $js = [
        'slimScroll/jquery.slimscroll.min.js',
        // 'sparkline/jquery.sparkline.min.js',
        'chartjs/Chart.min.js',
        'select2/select2.min.js',

    ];
}
