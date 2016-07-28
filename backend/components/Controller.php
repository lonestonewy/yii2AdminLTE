<?php
namespace backend\components;

use yii;
use yii\web\Controller as BaseController;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
/**
* 控制器基类
*/
class Controller extends BaseController
{
    public function behaviors()
    {
        // echo get_class(Yii::$app->authManager);die;
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function($rule, $action){
                            //超级管理员
                            if (!Yii::$app->user->isGuest && Yii::$app->user->isAdmin) {
                                return true;
                            }

                            $parts = explode('-', $action->controller->id);
                            $controllerName = '';
                            if(is_array($parts)){
                                foreach ($parts as $part) {
                                    $controllerName .= ucfirst($part);
                                }
                            }
                            $itemName = $controllerName.".*";
                            $subItemName = $controllerName.".".ucfirst($action->id);

                            $moduleName = $action->controller->module->id;
                            if(strpos($moduleName, 'app-')===false){
                                $itemName = ucfirst($moduleName).'.'.$itemName;
                                $subItemName = ucfirst($moduleName).'.'.$subItemName;
                            }

                            // 控制器权限
                            if(Yii::$app->user->can($itemName))
                                return true;

                            // 具体动作权限
                            return Yii::$app->user->can($subItemName);
                        },
                    ],
                ],
            ],
            [
                'class'=>\backend\components\BlankUrlFilter::className(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
}