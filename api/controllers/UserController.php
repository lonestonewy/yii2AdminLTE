<?php

namespace api\controllers;

use api\components\ActiveController;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        if (!Yii::$app->request->isOptions) {
            if (Yii::$app->request->headers->has('Authorization')) {
                $behaviors['authenticator'] = [
                    'class' => \yii\filters\auth\HttpBasicAuth::className(),
                ];
            }
        }

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'rules' => [
                [
                    'actions' => ['view', 'index'],
                    'allow' => true,
                ],
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'like' => ['post'],
                'ban' => ['post'],
                'set-read-only' => ['post'],
                'rank' => ['get'],
            ],
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['delete']);
        return $actions;
    }

    /**
     * 用户禁止访问，post
     * user_id 用户id
     * is_post_baned 布尔值 是否禁止访问
     */
    public function actionBan($id=null)
    {
        $post = Yii::$app->request->post();
        if(!$id) $id = $post['user_id'];
        $model = User::findOne(['id'=>$id, 'config_id'=>$this->config->id]);
        if ($model !== null) {
            $model->is_post_baned = $post['is_post_baned'];
            $model->save(false);

            return true;
        }

        return false;
    }

    /**
     * 用户禁言，post
     * user_id 用户id
     * is_post_readonly 布尔值 是否禁言
     */
    public function actionSetReadOnly($id=null)
    {
        $post = Yii::$app->request->post();
        if(!$id) $id = $post['user_id'];
        $model = User::findOne(['id'=>$id, 'config_id'=>$this->config->id]);
        if ($model !== null) {
            $model->is_post_readonly = $post['is_post_readonly'];
            $model->save(false);

            return true;
        }


        return false;
    }

    /**
     * 邀请排行榜
     */
    public function actionRank()
    {
        // $data['list']['all'] = Yii::$app->db->createCommand("SELECT a.*,(select count(*) from `user` as b where b.from_user_id = a.id) as invite_count FROM `user` as a WHERE config_id={$this->config->id} order by invite_count DESC limit 100")->queryAll();
        // $data['list']['month'] = Yii::$app->db->createCommand("SELECT a.*,(select count(*) from `user` as b where b.from_user_id = a.id and b.created_at >= date_sub(now(), INTERVAL 1 MONTH)) as invite_count FROM `user` as a WHERE config_id={$this->config->id} HAVING invite_count>0 order by invite_count DESC limit 100")->queryAll();
        // $data['rank']['all'] = 1 + Yii::$app->db->createCommand("select count(*) from (SELECT a.*,(select count(*) from `user` as b where b.from_user_id = a.id AND config_id={$this->config->id}) as invite_count FROM `user` as a WHERE config_id={$this->config->id}) as temp where invite_count >(select count(*) from `user` where from_user_id = :user_id AND config_id={$this->config->id})", ['user_id' => Yii::$app->user->id])->queryScalar();
        // $data['rank']['month'] = 1 + Yii::$app->db->createCommand("select count(*) from (SELECT a.*,(select count(*) from `user` as b where b.from_user_id = a.id AND config_id={$this->config->id} and b.created_at >= date_sub(now(), INTERVAL 1 MONTH)) as invite_count FROM `user` as a WHERE config_id={$this->config->id}) as temp where invite_count >(select count(*) from `user` where from_user_id = :user_id AND config_id={$this->config->id})", ['user_id' => Yii::$app->user->id])->queryScalar();
        return $data;
    }

    /**
     * 点赞，user_id 被赞的用户id
     */
    public function actionLike($id=null)
    {
        $post = Yii::$app->request->post();
        if(!$id) $id = $post['user_id'];
        $model = User::findOne(['id'=>$id, 'config_id'=>$this->config->id]);
        $key = 'user_like_' . $model->id . '_' . Yii::$app->user->id;
        $cache = Yii::$app->cache->get($key);
        if ($model !== null && $cache === false) {
            $model->updateCounters(['like_count' => 1]);
            Yii::$app->cache->set($key, 1, 24 * 3600);
            return true;
        }

        return false;
    }
}
