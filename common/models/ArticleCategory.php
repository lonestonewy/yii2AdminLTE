<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use common\components\ActiveRecord;
use common\components\behaviors\DatetimeBehavior;

/**
 * This is the model class for table "article_category".
 *
 * @property integer $id
 * @property string $name
 * @property integer $parent_id
 * @property integer $sortnum
 */
class ArticleCategory extends \common\components\ActiveRecord
{
    public $modelName = '资讯分类';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id'], 'required'],
            [['parent_id', 'sortnum'], 'integer'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '分类名称',
            'parent_id' => '所属父类',
            'sortnum' => '排序数字',
        ];
    }
}
