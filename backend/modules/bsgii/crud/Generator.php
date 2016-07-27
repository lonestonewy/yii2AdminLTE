<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\modules\bsgii\crud;

use Yii;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;
use yii\db\Schema;
use yii\gii\CodeFile;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\Controller;

/**
 * Generates CRUD
 *
 * @property array $columnNames Model column names. This property is read-only.
 * @property string $controllerID The controller ID (without the module ID prefix). This property is
 * read-only.
 * @property array $searchAttributes Searchable attributes. This property is read-only.
 * @property boolean|\yii\db\TableSchema $tableSchema This property is read-only.
 * @property string $viewPath The action view file path. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    public $modelClass;
    public $moduleID;
    public $controllerClass;
    public $baseControllerClass = 'backend\components\Controller';
    public $indexWidgetType = 'grid';
    public $searchModelClass = '';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'My CRUD Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a controller and views that implement CRUD (Create, Read, Update, Delete)
            operations for the specified data model.';
    }

    /**
     * Generates code for active search field
     * @param string $attribute
     * @return string
     */
    public function generateActiveSearchField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false) {
            return "\$form->field(\$model, '$attribute')";
        }
        $column = $tableSchema->columns[$attribute];

        $model = new $this->modelClass;
        $attributeLables = $model->attributeLabels();

        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute', ['labelOptions'=>['class'=>'sr-only']])->checkbox()";
        } else {
            return "\$form->field(\$model, '$attribute', ['labelOptions'=>['class'=>'sr-only'], 'inputOptions'=>['class'=>'form-control', 'placeholder'=>'{$attributeLables[$attribute]}']])";
        }
    }

    public function generateActiveGridField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                return "'$attribute' => ['type'=>Form::INPUT_PASSWORD, 'options'=>['placeholder'=>'']],";
            } else {
                return "'$attribute' => ['type'=>Form::INPUT_TEXT, 'options'=>['placeholder'=>'']],";
            }
        }
        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            return "'$attribute' => ['type'=>Form::INPUT_CHECKBOX],";
        } elseif ($column->type === 'text') {
            return "'$attribute' => ['type'=>Form::INPUT_TEXTAREA, 'options'=>['rows' => 6, 'placeholder'=>'']],";
        } else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                $input = 'Form::INPUT_PASSWORD';
            } else {
                $input = 'Form::INPUT_TEXT';
            }

            if (is_array($column->enumValues) && count($column->enumValues) > 0) {
                $dropDownOptions = [];
                foreach ($column->enumValues as $enumValue) {
                    $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
                }
                return "'$attribute' => ['type'=>FORM::INPUT_DROPDOWN_LIST, 'items'=>".preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)).", 'options'=>['class'=>'chosen-select', 'data-placeholder'=>'请选择', 'prompt'=>'']],";
            } elseif ($column->phpType !== 'string' || $column->size === null) {
                return "'$attribute' => ['type'=>$input, 'options'=>['placeholder'=>'']],";
            } else {
                return "'$attribute' => ['type'=>$input, 'options'=>['maxlength' => true, 'placeholder'=>'']],";
            }
        }
    }
}
