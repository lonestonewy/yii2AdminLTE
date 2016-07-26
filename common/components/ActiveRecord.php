<?php

namespace common\components;

use Yii;
use yii\db\ActiveRecord as BaseActiveRecord;
use yii\db\ActiveQuery;
use yii\web\UploadedFile;
use yii\web\ServerErrorHttpException;
use yii\base\Behavior;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\validators\FileValidator;
use yii\validators\ImageValidator;

class ActiveRecord extends BaseActiveRecord
{
    // SELECT FOR UPDATE 锁定
    public function lockForUpdate()
    {
        if ($this->getDb()->getTransaction() === null)
            throw new Exception('Running transaction is required');

        $pk = ArrayHelper::getValue(self::primaryKey(), 0);
        $this->getDb()->createCommand('SELECT 1 FROM `' . $this->tableName() . '` WHERE ' . $pk . ' = :pk FOR UPDATE', [
            ':pk' => $this->getPrimaryKey(),
        ])->execute();
    }

    /**
    * 抛出错误的保存方法
    */
    public function save($runValidation=true,$attributes=null, $throwException = true)
    {
        if($throwException)
        {
            if(!parent::save($runValidation, $attributes))
            {
                $ers = '';
                foreach($this->errors as $val)
                {
                    $ers[] = implode('', $val);
                }
                throw new \yii\base\UserException(implode('', $ers));
            }
            else
                return true;
        }
        else
            return parent::save($runValidation, $attributes);
    }

    /**
     * 后台操作日志记录
     * @param  boolean $newrecord 是否新增记录
     * @param  string  $attribute 名称字段
     * @param  string  $action    自定义操作
     * @param  array   $except    排除字段
     * @return boolean            总是成功
     */
    public function log($newrecord =true, $attribute = 'name', $action='', $except = [])
    {
        $except = array_combine($except, $except);
        $attributes = '';
        $dirtyAttributes = $this->getIdenticalDirtyAttributes(null, false);
        $changedAttributes = array_diff_key(array_intersect_key($this->oldAttributes, $dirtyAttributes), $except);
        if($changedAttributes) $attributes .= json_encode($changedAttributes, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        if($dirtyAttributes) $attributes .= "\n修改为\n".json_encode(array_diff_key($dirtyAttributes, $except), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);

        if(!$this->hasErrors()){
            if(!$action){
                if($newrecord){
                    Yii::info("录入{$this->modelName}[{$this->id}] {$this->$attribute}", 'admin');
                }
                else{
                    Yii::info("修改{$this->modelName}[{$this->id}] {$this->$attribute} \n".$attributes, 'admin');
                }
            }
            else{
                if($newrecord){
                    Yii::info("{$action}{$this->modelName}[{$this->id}] {$this->$attribute}", 'admin');
                }
                else{
                    Yii::info("{$action}{$this->modelName}[{$this->id}] {$this->$attribute} \n".$attributes, 'admin');
                }
            }
        }
        return true;
    }

    public function getIdenticalDirtyAttributes($names = null, $identical = true)
    {
        if ($names === null) {
            $names = $this->attributes();
        }
        $names = array_flip($names);
        $attributes = [];
        if ($this->oldAttributes === null) {
            foreach ($this->attributes as $name => $value) {
                if (isset($names[$name])) {
                    $attributes[$name] = $value;
                }
            }
        } else {
            foreach ($this->attributes as $name => $value) {
                if ($identical) {
                    if (isset($names[$name]) && (!array_key_exists($name, $this->oldAttributes) || $value !== $this->oldAttributes[$name])) {
                        $attributes[$name] = $value;
                    }
                }
                else{
                    if (isset($names[$name]) && (!array_key_exists($name, $this->oldAttributes) || $value != $this->oldAttributes[$name])) {
                        $attributes[$name] = $value;
                    }
                }
            }
        }
        return $attributes;
    }

    /**
     * 返回列表项目 供dropdownlist、checkboxlist、radiobuttonlist使用
     *
     * @param  string  $id     值字段名
     * @param  string  $name   名称字段名
     * @param  string  $group  分组字段名
     * @param  string  $sort   排序字段名
     * @param  string  $condition   附加查询条件
     * @return array
     */
    function getListData($valueField = 'id', $textField = 'name', $groupField = null, $sort='', $condition = '', $condition2 = '')
    {
        $key = get_class($this).$valueField.$textField.$groupField.$sort.$condition;
        $key = md5(Yii::$app->user->id.$key);

        // $data = Yii::$app->cache->get($key);
        // if ($data === false) {
            if(empty($sort)) $sort = $this->hasAttribute('sortnum') ? 'sortnum':'id';

            $sort = $this->hasAttribute('first_char') ? 'first_char':$sort;//首字母排序优先
            if(empty($groupField)) $groupField = $this->hasAttribute('first_char') ? 'first_char':null;//有首字母字段的，用于分组

            $query = Yii::createObject(ActiveQuery::className(), [get_class($this)]);
            $query->orderBy($sort.' ASC');

            if($this->hasAttribute('deleted')) $query->andWhere(['deleted'=>0]);
            if(!empty($condition)) $query->andWhere($condition);
            if(!empty($condition2)) $query->andWhere($condition2);

            $data = yii\helpers\ArrayHelper::map($query->all(), $valueField, $textField, $groupField);

            $dep = Yii::createObject([
                'class'=>'\yii\caching\DbDependency',
                'sql'=>"SELECT COUNT(*) FROM ".$this->tableName(),
            ]);

            // Yii::$app->cache->set($key, $data, 24*3600, $dep);
        // }

        return $data;
    }

    /**
     * 返回禁用项目 供dropdownlist、checkboxlist、radiobuttonlist使用
     * @param  string $valueField [description]
     * @return [type]             [description]
     */
    function getListOptions($valueField = 'id')
    {
        if(!$this->hasAttribute('stoped') && !$this->hasAttribute('is_enabled')) return array();

        $models = Yii::createObject(ActiveQuery::className(), [get_class($this)]);
        if($this->hasAttribute('deleted')) $models->where(['deleted'=>0]);

        $objs = $models->all();
        $options = array();
        foreach($objs as $data)
        {
            if($this->hasAttribute('stoped') && $data->stoped) $options[$data->$valueField] = array('disabled'=>true);
            if($this->hasAttribute('is_enabled') && !$data->is_enabled) $options[$data->$valueField] = array('disabled'=>true);
        }

        return $options;
    }

    function getConstOptions($prefix)
    {
        $options = array();

        $rec = new \ReflectionClass(get_class($this));
        $consts = $rec->getConstants();
        if(is_array($consts))
        {
            foreach($consts as $name=>$value)
            {
                if(strpos($name, $prefix) === 0) $options[$value] = $value;
            }
        }
        return $options;
    }

    /**
     * 处理上传文件
     * @param  array  $attributes 文件上传属性
     * @return void
     */
    public function uploadFiles(array $attributes, $extensions = ['jpg', 'png', 'jpeg', 'gif', 'zip', 'rar', '7z', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mp3'])
    {
        $className = explode('\\', get_class($this));
        $className = array_pop($className);

        $validator = new FileValidator(['skipOnEmpty' => true, 'extensions' => $extensions]);
        foreach($attributes as $attribute)
        {
            $file = UploadedFile::getInstance($this, $attribute);
            if($file !== null)
            {
                if($validator->validate($file, $error))
                {
                    $filename = time () . rand ( 1000, 9999 ) . '.' . $file->getExtension();

                    $dir = '/upload/'.strtolower($className).'/'.$attribute.'/' . date ( 'Ym' ) . '/';
                    if (! file_exists ( Yii::getAlias('@webroot') . $dir ))
                        FileHelper::createDirectory( Yii::getAlias('@webroot') . $dir);

                    $filepath = '@webroot' . $dir . $filename;
                    $filepath = Yii::getAlias($filepath);
                    if ($file->saveAs ( $filepath )) {
                        $this->$attribute = $dir . $filename;
                    }
                }
                else
                    $this->addError($attribute, $error);
            }
            else
                unset($this->$attribute);
        }
    }

    public function uploadImages(array $attributes, $extensions = ['jpg', 'png', 'jpeg', 'gif'])
    {
        $className = explode('\\', get_class($this));
        $className = array_pop($className);

        $validator = new ImageValidator(['skipOnEmpty' => true, 'extensions' => $extensions, 'maxSize'=>1024*1024, 'tooBig'=>'图片文件体积过大，不能超过{formattedLimit}.']);
        foreach($attributes as $attribute)
        {
            $file = UploadedFile::getInstance($this, $attribute);
            if($file !== null)
            {
                if($validator->validate($file, $error))
                {
                    $filename = time () . rand ( 1000, 9999 ) . '.' . $file->getExtension();

                    $dir = '/upload/'.strtolower($className).'/'.$attribute.'/' . date ( 'Ym' ) . '/';
                    if (! file_exists ( Yii::getAlias('@webroot') . $dir ))
                        FileHelper::createDirectory( Yii::getAlias('@webroot') . $dir);

                    $filepath = '@webroot' . $dir . $filename;
                    $filepath = Yii::getAlias($filepath);
                    if ($file->saveAs ( $filepath )) {
                        $this->$attribute = $dir . $filename;
                    }
                }
                else
                    $this->addError($attribute, $error);
            }
            else
                unset($this->$attribute);
        }
    }
}