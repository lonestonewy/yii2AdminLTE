<?php
namespace api\components;

use common\base\InvalidParamException;
use common\models\WechatConfig;
use yii;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\filters\ContentNegotiator;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController as Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
* ActiveController
*/
class ActiveController extends Controller
{
    public $config; // 当前微信配置
    public $wechat; // easywechat实例
    public $miniapp;
    public $payment;

    public function init()
    {
        parent::init();
        Yii::$app->user->enableSession = false;
        $get = Yii::$app->request->get();

        if(!$get['appid']){
            throw new InvalidParamException('接口请求地址缺少必要的APPID参数');
        }

        // $this->config = WechatConfig::findOne(['appid'=>$get['appid']]);
        // if($this->config === null){
        //     throw new NotFoundHttpException('没有找到这个APPID对应的配置');
        // }
        // $this->wechat =$this->config->getWechatApp();
        // $this->miniapp = $this->config->getMiniApp();
        // $this->payment = $this->config->getPayment();
    }

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    //header传参：key=>Authorization,value=>Bearer (access_token)
    //或GET传参：key=>access_token,value=>(access_token)
    public function behaviors()
    {
         $behaviors = ArrayHelper::merge(['corsFilter'=>
             [
                 'class' => Cors::className(),
                 'cors' => [
                     'Origin' => Yii::$app->params['origins'],
                     'Access-Control-Request-Method' => ['GET','HEAD','POST', 'PUT', 'DELETE', 'OPTIONS'],
                     'Access-Control-Allow-Credentials' => true,
                     'Access-Control-Max-Age' => 3600,
                     'Access-Control-Request-Headers' => ['X-Requested-With', 'Content-Type', 'accept', 'Authorization'],
                     'Access-Control-Expose-Headers' => ['Origin', 'Access-Control-Allow-Origin', 'X-Pagination-Total-Count', 'X-Pagination-Page-Count', 'X-Pagination-Current-Page', 'X-Pagination-Per-Page'],
                 ]
             ]
         ],parent::behaviors());

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'text/html' => Response::FORMAT_JSON,
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
            ],
        ];

        unset($behaviors['rateLimiter']);
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // 禁用"delete" 和 "create" 动作
        // unset($actions['delete'], $actions['create']);

        // 使用"prepareDataProvider()"方法自定义数据provider
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['create']['class'] = 'api\components\CreateAction';

        return $actions;
    }

    public function prepareDataProvider()
    {
        /* @var $modelClass \yii\db\BaseActiveRecord */
        $modelClass = $this->modelClass;

        $lastSlash = strrpos($modelClass, '\\')+1;
        $searchModelClass = substr($modelClass, 0, $lastSlash-1)."\\search\\". substr($modelClass, $lastSlash).'Search';
        if(!class_exists($searchModelClass)){
            $searchModelClass = "common\\models\\search\\". substr($modelClass, $lastSlash).'Search';
        }

        $filter = new ActiveDataFilter([
            'searchModel' => $searchModelClass,
        ]);
        
        $filterCondition = null;
        $get = \Yii::$app->request->get();
        if (isset($get['filter'])&&$filter->filter=Json::decode($get['filter'])) { 
            $filterCondition = $filter->build();
            if ($filterCondition === false) {
                // Serializer would get errors out of it
                return $filter;
            }
        }
        
        $query = $modelClass::find();
        if ($filterCondition !== null) {
            $query->andWhere($filterCondition);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['id'=> SORT_DESC], 'enableMultiSort'=>true],
            'pagination'=>['validatePage'=>false],
        ]);
        $dataProvider->query->andFilterWhere(['config_id' => $this->config->id]);
        return $dataProvider;
    }

    /**
     * Checks the privilege of the current user.
     *
     * This method should be overridden to check whether the current user has the privilege
     * to run the specified action against the specified data model.
     * If the user does not have access, a [[ForbiddenHttpException]] should be thrown.
     *
     * @param string $action the ID of the action to be executed
     * @param object $model the model to be accessed. If null, it means no specific model is being accessed.
     * @param array $params additional parameters
     * @throws ForbiddenHttpException if the user does not have access
     */
    public function checkAccess($action, $model = null, $params = [])
    {
        if($action == 'delete' || $action == 'update'){
            if($model->hasAttribute('user_id') && $model->user_id && !Yii::$app->user->isGuest ){
                if($model->user_id != Yii::$app->user->id){
                    throw new ForbiddenHttpException('You can not delete the data does not belongs to yourself! model->user_id = '.$model->user_id.', user_id='.Yii::$app->user->id);
                }
            }
            // if($model->hasAttribute('config_id') && $this->config->id!=$model->config_id ){
            //     throw new ForbiddenHttpException('You can not delete the data does not belongs to current app!');
            // }
        }
    }
}