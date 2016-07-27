<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace common\components\behaviors;

use yii\behaviors\AttributeBehavior;
use yii\base\InvalidCallException;
use yii\db\BaseActiveRecord;

/**
 * DatetimeBehavior automatically fills the specified attributes with the current datetime.
 *
 * To use DatetimeBehavior, insert the following code to your ActiveRecord class:
 *
 * ```php
 * use yii\behaviors\DatetimeBehavior;
 *
 * public function behaviors()
 * {
 *     return [
 *         DatetimeBehavior::className(),
 *     ];
 * }
 * ```
 *
 * By default, DatetimeBehavior will fill the `created_at` and `updated_at` attributes with the current datetime
 * when the associated AR object is being inserted; it will fill the `updated_at` attribute
 * with the datetime when the AR object is being updated. The datetime value is obtained by `time()`.
 *
 * For the above implementation to work with MySQL database, please declare the columns(`created_at`, `updated_at`) as int(11) for being UNIX datetime.
 *
 * If your attribute names are different or you want to use a different way of calculating the datetime,
 * you may configure the [[createdAtAttribute]], [[updatedAtAttribute]] and [[value]] properties like the following:
 *
 * ```php
 * use yii\db\Expression;
 *
 * public function behaviors()
 * {
 *     return [
 *         [
 *             'class' => DatetimeBehavior::className(),
 *             'createdAtAttribute' => 'create_time',
 *             'updatedAtAttribute' => 'update_time',
 *             'value' => new Expression('NOW()'),
 *         ],
 *     ];
 * }
 * ```
 *
 * In case you use an [[\yii\db\Expression]] object as in the example above, the attribute will not hold the datetime value, but
 * the Expression object itself after the record has been saved. If you need the value from DB afterwards you should call
 * the [[\yii\db\ActiveRecord::refresh()|refresh()]] method of the record.
 *
 * DatetimeBehavior also provides a method named [[touch()]] that allows you to assign the current
 * datetime to the specified attribute(s) and save them to the database. For example,
 *
 * ```php
 * $model->touch('creation_time');
 * ```
 *
 * @author 王勇 <lonestone@qq.com>
 * @since 2.0
 */
class DatetimeBehavior extends AttributeBehavior
{
    /**
     * @var string the attribute that will receive datetime value
     * Set this property to false if you do not want to record the creation time.
     */
    public $createdAtAttribute = 'created_at';
    /**
     * @var string the attribute that will receive datetime value.
     * Set this property to false if you do not want to record the update time.
     */
    public $updatedAtAttribute = 'updated_at';
    /**
     * @inheritdoc
     *
     * In case, when the value is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
     * will be used as value.
     */
    public $value;


    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (empty($this->attributes)) {
            $this->attributes = [
                BaseActiveRecord::EVENT_BEFORE_INSERT => [$this->createdAtAttribute, $this->updatedAtAttribute],
                BaseActiveRecord::EVENT_BEFORE_UPDATE => $this->updatedAtAttribute,
            ];
        }
    }

    /**
     * @inheritdoc
     *
     * In case, when the [[value]] is `null`, the result of the PHP function [time()](http://php.net/manual/en/function.time.php)
     * will be used as value.
     */
    protected function getValue($event)
    {
        if ($this->value === null) {
            return date('Y-m-d H:i:s');
        }
        return parent::getValue($event);
    }

    /**
     * Updates a datetime attribute to the current datetime.
     *
     * ```php
     * $model->touch('lastVisit');
     * ```
     * @param string $attribute the name of the attribute to update.
     * @throws InvalidCallException if owner is a new record (since version 2.0.6).
     */
    public function touch($attribute)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        if ($owner->getIsNewRecord()) {
            throw new InvalidCallException('Updating the datetime is not possible on a new record.');
        }
        $owner->updateAttributes(array_fill_keys((array) $attribute, $this->getValue(null)));
    }
}
