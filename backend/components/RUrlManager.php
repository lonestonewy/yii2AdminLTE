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
        if(Yii::$app->user->IsAdmin){
            return parent::createUrl($params);
        }

        $access = Yii::$app->session['access-'.Yii::$app->user->id];
        if($access === null){
            $access = (!Yii::$app->user->isGuest && !Yii::$app->user->IsAdmin);
            Yii::$app->session['access-'.Yii::$app->user->id] = $access;
        }
        if($access)
        {
            $route = explode('/', $params[0]);

            $modules = array_keys(Yii::$app->getModules());
            $module_count = 0;
            foreach($route as $id){
                if(in_array($id, $modules)){
                    $module_count++;
                }
            }
            if($module_count>0){
                if(count($route) == $module_count){
                    $route[$module_count] = 'default';
                    $route[$module_count+1] = 'index';
                }
                if(count($route) == $module_count + 1){
                    $route[$module_count + 1] = 'index';
                }
            }

            if(count($route) === 1) $route[1]='index';
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

                if(!Yii::$app->user->can($itemName) && !Yii::$app->user->can($subItemName)){
                    return false;
                }
            }elseif(count($route) === 3){
                if($route[0]!='debug' && $route[0]!='gii'){
                    $parts = explode('-', $route[1]);
                    $controllerName = ucfirst($route[0]).'.';
                    if(is_array($parts)){
                        foreach ($parts as $part) {
                            $controllerName .= ucfirst($part);
                        }
                    }
                    $itemName = $controllerName.".*";
                    $subItemName = $controllerName.".".ucfirst($route[2]);
                    if(!Yii::$app->user->can($itemName) && !Yii::$app->user->can($subItemName)){
                        return false;
                    }
                }
            }else{
                return false;
            }
        }

        return parent::createUrl($params);
    }
}