<?php

/**
 * @author Vladimir Konchakovsky <wowkaster@gmail.com>
 */

namespace common\components\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\db\BaseActiveRecord;
use yii\helpers\Json;


class SerializeAttributesBehavior extends AttributeBehavior{

    const DEFAULT_CONVERT_TYPE = 'serialize';

    /**
     * @var array
     */
    private $allowConvertType = ['json', 'serialize'];

    /**
     * @var array
     */
    public $convertAttr = [];

    public function init() {
        parent::init();

        if (empty($this->attributes)) {
            foreach($this->convertAttr as $key => $value) {
                $attrName = is_scalar($key) ? $key : $value;
                $convertType = is_scalar($key) ? $value : self::DEFAULT_CONVERT_TYPE;

                if(!in_array($convertType, $this->allowConvertType)) {
                    throw new \Exception(strtr('Disallow type convert "{type}"', ['{type}' => $convertType]));
                }

                $this->attributes[BaseActiveRecord::EVENT_BEFORE_INSERT][] = $attrName;
                $this->attributes[BaseActiveRecord::EVENT_BEFORE_UPDATE][] = $attrName;
                $this->attributes[BaseActiveRecord::EVENT_AFTER_FIND][] = $attrName;
                $this->attributes[BaseActiveRecord::EVENT_AFTER_INSERT][] = $attrName;
                $this->attributes[BaseActiveRecord::EVENT_AFTER_UPDATE][] = $attrName;
            }
        }
    }

    /**
     * @param \yii\base\Event $event
     * @return string
     */
    public function getValue($event) {

        foreach($this->convertAttr as $key => $value) {

            $attrName = is_scalar($key) ? $key : $value;
            $convertType = is_scalar($key) ? $value : self::DEFAULT_CONVERT_TYPE;
            $data = $this->owner->getAttribute($attrName);

            if(in_array($event->name, [BaseActiveRecord::EVENT_BEFORE_INSERT, BaseActiveRecord::EVENT_BEFORE_UPDATE])) {
                return $this->getConvertValue((array)$data, $convertType);
            } elseif(in_array($event->name, [BaseActiveRecord::EVENT_AFTER_FIND, BaseActiveRecord::EVENT_AFTER_INSERT, BaseActiveRecord::EVENT_AFTER_UPDATE])) {
                return $this->getUnConvertValue($data, $convertType);
            } else {
                return $data;
            }
        }
    }

    /**
     * @param array $value
     * @param $type
     * @return string
     */
    private function getConvertValue(array $value, $type) {

        if($value && $type == self::DEFAULT_CONVERT_TYPE) {
            $value = serialize($value);
        } else {
            $value = Json::encode($value);
        }

        return $value;
    }

    /**
     * @param $value
     * @param $type
     * @return array
     */
    private function getUnConvertValue($value, $type) {
        if($value){
            if($type == self::DEFAULT_CONVERT_TYPE) {
                try {
                    $value = unserialize($value);
                } catch(\Exception $e) {
                    trigger_error($e);
                }
            } else {
                $value = Json::decode($value);
            }
        }
        return $value;
    }
}
