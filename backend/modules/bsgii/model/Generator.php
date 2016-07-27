<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\modules\bsgii\model;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Connection;
use yii\db\Schema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\base\NotSupportedException;

/**
 * This generator will generate one or multiple ActiveRecord classes for the specified database table.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\model\Generator
{
    const RELATIONS_NONE = 'none';
    const RELATIONS_ALL = 'all';
    const RELATIONS_ALL_INVERSE = 'all-inverse';


    public $db = 'db';
    public $ns = 'common\models';
    public $tableName;
    public $modelClass;
    public $baseClass = 'common\components\ActiveRecord';
    public $generateRelations = true;
    public $generateLabelsFromComments = false;
    public $useTablePrefix = false;
    public $useSchemaName = true;
    public $generateQuery = false;
    public $queryNs = 'common\models';
    public $queryClass;
    public $queryBaseClass = 'yii\db\ActiveQuery';


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'AdminLTE Model Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates an ActiveRecord class for the specified database table.';
    }
}
