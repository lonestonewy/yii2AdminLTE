<?php
/**
 * @copyright Copyright (c) 2013-15 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * CKEditorAsset
 */
class CKFinderAsset extends AssetBundle
{
    public $js = [
        'ckfinder/ckfinder.js',
    ];

    public $depends = [
        'dosamigos\ckeditor\CKEditorAsset',
    ];
}
