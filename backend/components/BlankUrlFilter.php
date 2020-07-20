<?php
namespace backend\components;

use Yii;
use yii\base\ActionFilter;

/**
 * 用于配合权限控制，过滤空链接
 */
class BlankUrlFilter extends ActionFilter
{
    public function afterAction($action, $result)
    {
        if(is_string($result)){
            $pattern = '/<a.+?>.+?<\/a>/i';
            $result = preg_replace_callback($pattern, function($matches){
                if(strpos($matches[0], 'href=')===false){
                    return '';
                }
                return $matches[0];
            }, $result);
        }
        return parent::afterAction($action, $result);
    }
}