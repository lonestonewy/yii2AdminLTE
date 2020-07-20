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
 * videojs
 */
class VideojsAsset extends AssetBundle
{
    public $css = [
        'css/video-js.min.css',
        'https://g.alicdn.com/de/prismplayer/2.8.2/skins/default/aliplayer-min.css',
    ];

    public $js = [
        'js/video.min.js',
        'js/videojs-contrib-hls.min.js',
        'js/videojs-flash.min.js',
        'js/videojs-zh-CN.js',
        'https://g.alicdn.com/de/prismplayer/2.8.2/aliplayer-min.js',
    ];
}
