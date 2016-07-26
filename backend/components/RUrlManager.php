<?php
namespace backend\components;

use yii;
use yii\web\UrlManager;

class RUrlManager extends UrlManager
{
    /**
     * Constructs a URL. 增加权限验证
     */
    public function createUrl($params)
    {
        $access = Yii::$app->session['access-'.Yii::$app->user->id];
        if($access === null){
            $access = (!Yii::$app->user->isGuest && !Yii::$app->user->IsAdmin);
            Yii::$app->session['access-'.Yii::$app->user->id] = $access;
        }
        if($access)
        {
            $route = explode('/', $params[0]);

            if(count($route) === 2){
                $parts = explode('-', $route[0]);
                $controllerName = '';
                if(is_array($parts)){
                    foreach ($parts as $part) {
                        $controllerName .= ucfirst($part);
                    }
                }

                $itemName = $controllerName.".*";
                $subItemName = $controllerName.".".ucfirst($route[1]);

                if(!Yii::$app->user->can($itemName))
                {
                    if(!Yii::$app->user->can($subItemName)) return false;
                }
            }
            elseif(count($route) === 3){
                $parts = explode('-', $route[1]);
                $controllerName = ucfirst($route[0]).'.';;
                if(is_array($parts)){
                    foreach ($parts as $part) {
                        $controllerName .= ucfirst($part);
                    }
                }

                $itemName = $controllerName.".*";
                $subItemName = $controllerName.".".ucfirst($route[2]);

                if(!Yii::$app->user->can($itemName))
                {
                    if(!Yii::$app->user->can($subItemName)) return false;
                }
            }
        }

        return parent::createUrl($params);
    }
}