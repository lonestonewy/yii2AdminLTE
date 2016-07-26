<?php
/**
* Nav with sub menus
*/
namespace backend\components;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\Dropdown;

class BsNav extends Nav
{
    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();

        if(Yii::$app->user->IsAdmin)
            return;

        foreach($this->items as $key => $item){
            if(!is_array($item)) continue;
            if(isset($item['url']) && is_array($item['url'])){
                $route = explode('/', trim($item['url'][0], '/'));
                if(count($route) === 2){
                    $parts = explode('-', $route[0]);
                    $controllerName = '';
                    if(is_array($parts)){
                        foreach ($parts as $part) {
                            $controllerName .= ucfirst($part);
                        }
                    }
                    $itemName = $controllerName.".*";
                    $subItemName = $controllerName.".".ucfirst($route[1]);

                    if(!Yii::$app->user->can($itemName) && !Yii::$app->user->can($subItemName)){
                        unset($this->items[$key]);
                    }
                }elseif(count($route) === 3){
                    $parts = explode('-', $route[1]);
                    $controllerName = ucfirst($route[0]).'.';
                    if(is_array($parts)){
                        foreach ($parts as $part) {
                            $controllerName .= ucfirst($part);
                        }
                    }
                    $itemName = $controllerName.".*";
                    $subItemName = $controllerName.".".ucfirst($route[2]);
                    if(!Yii::$app->user->can($itemName) && !Yii::$app->user->can($subItemName)){
                        unset($this->items[$key]['items'][$index]);
                    }
                }else{
                    unset($this->items[$key]);
                }
            }

            $subcount = count($this->items[$key]['items']);
            if(count($this->items[$key]['items']) > 0){
                foreach($this->items[$key]['items'] as $index => $item){
                    if(!is_array($item)) continue;
                    if(isset($item['url']) && is_array($item['url'])){

                        $route = explode('/', trim($item['url'][0], '/'));
                        if(count($route) === 2){
                            $parts = explode('-', $route[0]);
                            $controllerName = '';
                            if(is_array($parts)){
                                foreach ($parts as $part) {
                                    $controllerName .= ucfirst($part);
                                }
                            }
                            $itemName = $controllerName.".*";
                            $subItemName = $controllerName.".".ucfirst($route[1]);
                            if(!Yii::$app->user->can($itemName) && !Yii::$app->user->can($subItemName)){
                                unset($this->items[$key]['items'][$index]);
                            }
                        }elseif(count($route) === 3){
                            $parts = explode('-', $route[1]);
                            $controllerName = ucfirst($route[0]).'.';
                            if(is_array($parts)){
                                foreach ($parts as $part) {
                                    $controllerName .= ucfirst($part);
                                }
                            }
                            $itemName = $controllerName.".*";
                            $subItemName = $controllerName.".".ucfirst($route[2]);
                            if(!Yii::$app->user->can($itemName) && !Yii::$app->user->can($subItemName)){
                                unset($this->items[$key]['items'][$index]);
                            }
                        }else{
                            unset($this->items[$key]['items'][$index]);
                        }
                    }
                }
            }

            if(count($this->items[$key]['items']) === 0){
                if($subcount>0) unset($this->items[$key]);
            }
        }
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        if(count($this->items) == 0){
            return '';
        }

        return parent::run();
    }

    /**
     * Renders a widget's item.
     * @param string|array $item the item to render.
     * @return string the rendering result.
     * @throws InvalidConfigException
     */
    public function renderItem($item)
    {
        if (is_string($item)) {
            return $item;
        }
        if (!isset($item['label'])) {
            throw new InvalidConfigException("The 'label' option is required.");
        }
        $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
        $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
        $options = ArrayHelper::getValue($item, 'options', []);
        $items = ArrayHelper::getValue($item, 'items');
        $url = ArrayHelper::getValue($item, 'url', '#');
        $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);

        if (isset($item['active'])) {
            $active = ArrayHelper::remove($item, 'active', false);
        } else {
            $active = $this->isItemActive($item);
        }

        if ($items !== null) {
            if ($this->dropDownCaret !== '') {
                $label .= ' ' . $this->dropDownCaret;
            }
            if (is_array($items)) {
                if ($this->activateItems) {
                    $items = $this->isChildActive($items, $active);
                }
                $items = $this->renderDropdown($items, $item);
            }
        }

        if ($this->activateItems && $active) {
            Html::addCssClass($options, 'active');
        }

        return Html::tag('li', Html::a($label, $url, $linkOptions) . $items, $options);
    }

    /**
     * Renders the given items as a dropdown.
     * This method is called to create sub-menus.
     * @param array $items the given items. Please refer to [[Dropdown::items]] for the array structure.
     * @param array $parentItem the parent item information. Please refer to [[items]] for the structure of this array.
     * @return string the rendering result.
     * @since 2.0.1
     */
    protected function renderDropdown($items, $parentItem)
    {
        return BsNav::widget([
            'items' => $items,
            'encodeLabels' => $this->encodeLabels,
            'clientOptions' => false,
            'options'=>['class'=>'nav nav-second-level collapse'],
            // 'view' => $this->getView(),
        ]);
    }
}