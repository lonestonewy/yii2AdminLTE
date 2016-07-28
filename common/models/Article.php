<?php

namespace common\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use common\components\ActiveRecord;
use common\components\behaviors\DatetimeBehavior;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $image
 * @property string $keywords
 * @property string $summary
 * @property string $content
 * @property integer $views
 * @property integer $sortnum
 * @property string $commend_level
 * @property integer $is_enabled
 * @property string $created_at
 * @property string $updated_at
 */
class Article extends \common\components\ActiveRecord
{
    public $modelName = '资讯';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }
    public function behaviors()
    {
        return [
            DatetimeBehavior::className(),
        ];
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'summary', 'content'], 'required'],
            [['category_id', 'views', 'sortnum', 'is_enabled'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title'], 'string', 'max' => 80],
            [['image'], 'string', 'max' => 100],
            [['keywords', 'commend_level'], 'string', 'max' => 50],
            [['summary'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => '所属分类',
            'title' => '文章标题',
            'image' => '标题图片',
            'keywords' => '关键词',
            'summary' => '内容简介',
            'content' => '文章内容',
            'views' => '浏览次数',
            'sortnum' => '排序数字',
            'commend_level' => '推荐级别',
            'is_enabled' => '是否有效',
            'created_at' => '添加时间',
            'updated_at' => '修改时间',
        ];
    }

    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id'=>'category_id']);
    }
}
