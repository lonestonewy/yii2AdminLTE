<?php
namespace api\controllers;

use api\components\Controller;
use InvalidArgumentException;
use Yii;

class ConfigController extends Controller
{
    public function actionGet($key, $as_array = false){
        $data = Yii::$app->config->get($this->config->id, $key);
        if($as_array && !is_array($data)){
            $data = explode(',', $data);
        }

        return $data;
    }

    public function actionGetAll(){
        $data = Yii::$app->config->getAll($this->config->id);
        unset($data['aliyun_accesskey_id']);
        unset($data['aliyun_accesskey_secret']);
        unset($data['aliyun_domain_hosted']);
        unset($data['aliyun_live_domain']);
        unset($data['live_play_apiauth']);
        unset($data['live_push_apiauth']);
        return $data;
    }

    public function actionParams($key){
        $keys = ['bank_codes'];
        if(!in_array($key, $keys)){
            throw new InvalidArgumentException('无效的参数');
        }
        return Yii::$app->params[$key];
    }
}