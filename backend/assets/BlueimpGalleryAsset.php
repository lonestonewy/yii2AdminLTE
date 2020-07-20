<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;
use yii\web\View;

/**
 * blueimp-gallery jquery plugin
 */
class BlueimpGalleryAsset extends AssetBundle
{
    public $sourcePath = '@bower/blueimp-gallery';

    public $css = [
        'css/blueimp-gallery.min.css',
    ];

    public $js = [
        'js/blueimp-gallery.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
