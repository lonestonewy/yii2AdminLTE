<?php

namespace api\modules\v1\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use api\modules\v1\models\User;

/**
 * UserSearch represents the model behind the search form about `api\modules\v1\models\User`.
 */
class UserSearch extends User
{
    public $subscribe_at_from, $subscribe_at_to;

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=>['defaultOrder'=>['id'=> SORT_DESC]],
            'pagination'=>['validatePage'=>false],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'config_id' => $this->config_id,
            'status' => $this->status,
            'subscribe' => $this->subscribe,
            'subscribe_at' => $this->subscribe_at,
            'unsubscribe_at' => $this->unsubscribe_at,
            'birthdate' => $this->birthdate,
            'groupid' => $this->groupid,
            'scene_id' => $this->scene_id,
            'from_user_id' => $this->from_user_id,
            'is_post_baned' => $this->is_post_baned,
            'is_post_readonly' => $this->is_post_readonly,
        ]);

        $query->andFilterWhere(['like', 'access_token', $this->access_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'openid', $this->openid])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'headimgurl', $this->headimgurl])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        $query->andFilterWhere(['>=', 'subscribe_at', $this->subscribe_at_from])
            ->andFilterWhere(['<=', 'subscribe_at', $this->subscribe_at_to]);

        return $dataProvider;
    }
}
