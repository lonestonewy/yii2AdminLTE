<?php
namespace api\components;

use common\base\InvalidParamException;
use common\models\Agent;
use common\models\Image;
use common\models\Merchant;
use common\models\WechatConfig;
use yii;
use yii\web\Controller as BaseController;
use yii\web\NotFoundHttpException;

/**
* 控制器基类
*/
class Controller extends BaseController
{
    public $config;
    public $wechat;
    public $miniapp;
    public $payment;
    public $platformWechat;
    public $enableCsrfValidation = false;

    public function init()
    {
        parent::init();
        $get = Yii::$app->request->get();

        if(!$get['appid']){
            throw new InvalidParamException('接口请求地址缺少必要的APPID参数');
        }

        // $this->config = WechatConfig::findOne(['appid'=>$get['appid']]);
        // if($this->config === null){
        //     throw new NotFoundHttpException('没有找到这个APPID对应的配置');
        // }
        // $this->wechat = $this->config->getWechatApp();
        // $this->miniapp = $this->config->getMiniApp();
        // $this->payment = $this->config->getPayment();
    }

    public function beforeAction($action)
    {
        if (YII_ENV === 'dev') {
            // $model = \common\models\User::findOne(1);
            // Yii::$app->session['openid'] = $model->openid;
            // Yii::$app->user->login($model, 86400);
        }
        // 推广UID
        if(isset($_GET['fromuid'])){
            Yii::$app->session['fromuid'] = intval($_GET['fromuid']);
        }
        return parent::beforeAction($action);
    }
}