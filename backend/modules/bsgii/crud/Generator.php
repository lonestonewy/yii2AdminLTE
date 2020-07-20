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
    public $foreignKeyClassNames = [];

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'AdminLTE CRUD Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a controller and views that implement CRUD (Create, Read, Update, Delete)
            operations for the specified data model.';
    }

    public function generate() {
        $tableSchema = $this->getTableSchema();
        foreach($tableSchema->columns as $attribute=>$column) {
            $this->getForeignKeyClassName($column->name);
        }
        return parent::generate();
    }

    /**
     * Generates column format
     * @param \yii\db\ColumnSchema $column
     * @return string
     */
    public function generateColumnFormat($column)
    {
        if ($column->phpType === 'boolean'||($column->type=='smallint'&&strpos($column->name, 'is_')===0)) {
            return 'boolean';
        } elseif ($column->type === 'text'&&in_array($column->name, ['content', 'detail'])) {
            return 'html';
        } elseif ($column->type === 'text') {
            return 'ntext';
        } elseif (stripos($column->name, 'time') !== false && $column->phpType === 'integer') {
            return 'datetime';
        } elseif (stripos($column->name, 'email') !== false) {
            return 'email';
        } elseif (stripos($column->name, 'url') !== false) {
            return 'url';
        } else {
            return 'text';
        }
    }

    // 根据反射提取类常量字段
    public function getConstsAttributes() {
        $rec = new \ReflectionClass($this->modelClass);
        $consts = $rec->getConstants();
        $constsAttributes = [];
        if (is_array($consts)) {
            foreach ($consts as $name => $value) {
                $constsAttributes[] = strtolower(substr($name, 0, strrpos($name, '_')));
            }
        }
        return array_unique($constsAttributes);
    }

    public function getForeignKeyClassName($attribute) {
        $suffix = substr($attribute, -3);
        if($suffix !== '_id') return;
        $attribute = substr($attribute, 0, strlen($attribute)-3);
        $namespace = substr($this->modelClass, 0, strrpos($this->modelClass, '\\'));
        $className = '\\'.$namespace.'\\'.ucfirst($attribute);
        eval("use $className;");
        if(\class_exists($className)) {
            $this->foreignKeyClassNames[ucfirst($attribute)] = $className;
            return [ucfirst($attribute), $className];
        }

        $aliases = Yii::$aliases;
        foreach($aliases as $alias => $path){
            $namespace = substr($alias, 1).'\\models';
            $className = '\\'.$namespace.'\\'.ucfirst($attribute);
            eval("use $className;");
            if(\class_exists($className)) {
                $this->foreignKeyClassNames[ucfirst($attribute)] = $className;
                return [ucfirst($attribute), $className];
            }
        }
    }

    /**
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateActiveField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                return "\$form->field(\$model, '$attribute')->passwordInput()";
            } else {
                return "\$form->field(\$model, '$attribute')";
            }
        }

        $column = $tableSchema->columns[$attribute];
        list($foreignKeyClassName, $fullForeignKeyClassName) = $this->getForeignKeyClassName($column->name);
        if ($column->type === 'integer' && $foreignKeyClassName) {
            return "\$form->field(\$model, '$attribute')->dropdownList({$foreignKeyClassName}::instantiate([])->getListData(), ['class'=>'select2', 'style'=>'width:100%', 'data-placeholder'=>'{$column->comment}', 'prompt'=>''])";
        } elseif (strpos($column->name, 'is_')===0) {
            return "\$form->field(\$model, '$attribute')->radiolist(['1'=>'是', '0'=>'否'], ['itemOptions'=>['class'=>'minimal']])";
        } elseif ($column->type === 'text'&&in_array($column->name, ['content', 'detail'])) {
            return "\$form->field(\$model, '$attribute')->widget(backend\widgets\CKEditor::classname())";
        } elseif ($column->type === 'text' || ($column->type === 'string' && $column->size>100)) {
            return "\$form->field(\$model, '$attribute')->textarea(['rows' => 6])";
        } elseif ($column->type === 'string' && in_array($column->name, ['image', 'photo', 'filepath', 'screenshot', 'attach'])) {
            return "\$form->field(\$model, '$attribute')->widget(backend\widgets\FileInput::classname())->hint('支持JPG、PNG格式，不要超过500KB为宜')";
        } elseif ($column->type === 'string' && in_array(strtolower($column->name), $this->getConstsAttributes())) {
            return "\$form->field(\$model, '$attribute')->dropdownList(\$model->getConstOptions('".strtoupper($column->name)."'), ['class'=>'select2', 'style'=>'width:100%', 'data-placeholder'=>'{$column->comment}', 'prompt'=>''])";
        }else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                $input = 'passwordInput';
            } else {
                $input = 'textInput';
            }
            if (is_array($column->enumValues) && count($column->enumValues) > 0) {
                $dropDownOptions = [];
                foreach ($column->enumValues as $enumValue) {
                    $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
                }
                return "\$form->field(\$model, '$attribute')->dropDownList("
                    . preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)).", ['prompt' => ''])";
            } elseif ($column->phpType !== 'string' || $column->size === null) {
                return "\$form->field(\$model, '$attribute')->$input()";
            } else {
                return "\$form->field(\$model, '$attribute')->$input(['maxlength' => true])";
            }
        }
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
        } elseif ($column->type === 'string' && in_array(strtolower($column->name), $this->getConstsAttributes())) {
            return "\$form->field(\$model, '$column->name', ['labelOptions'=>['class'=>'sr-only']])->dropdownList(\$model->getConstOptions('".strtoupper($column->name)."'), ['prompt'=>'', 'data-placeholder'=>'不限{$column->comment}', 'class'=>'form-control select2', 'style'=>'width:120px'])";
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
