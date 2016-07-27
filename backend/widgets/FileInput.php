<?php
namespace backend\widgets;

use Yii;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * FileInput widget styled for Bootstrap 3.0 with ability to multiple file
 * selection and preview, format button styles and inputs. Runs on all modern
 * browsers supporting HTML5 File Inputs and File Processing API. For browser
 * versions IE9 and below, this widget will gracefully degrade to normal HTML
 * file input.
 *
 * Wrapper for the Bootstrap FileInput JQuery Plugin
 *
 * @see http://www.jasny.net/bootstrap/javascript/#fileinput
 *
 * @author 王勇 <lonestone@qq.com>
 * @since 2.0
 */
class FileInput extends \kartik\base\InputWidget
{
    /**
     * @var array initialize the FileInput widget
     */
    public function init()
    {
        parent::init();
        $this->_msgCat = 'fileinput';
        $this->registerAssets();
        if ($this->pluginLoading) {
            Html::addCssClass($this->options, 'file-loading');
        }

        if ($this->hasModel()) {
            $input = Html::activeFileInput($this->model, $this->attribute, $this->options);
        }
        else{
            $input = Html::fileInput($this->name, $this->value, $this->options);
        }

        $content = '<div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename">'.basename($this->value).'</span></div>
                    <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">选择</span><span class="fileinput-exists">更换</span>
                    '.$input.'
                    </span>
                    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">删除</a>';

        $input = Html::tag('div', $content, ['class'=>'fileinput fileinput-new input-group', 'data-provides'=>'fileinput']);

        echo $input;
    }

    /**
     * Registers the asset bundle and locale
     */
    public function registerAssetBundle() {
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $this->registerAssetBundle();
    }
}