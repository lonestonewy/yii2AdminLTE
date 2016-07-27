<?php
namespace backend\widgets;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\Html;
use yii\base\Widget;
use yii\data\Pagination;
use yii\widgets\LinkPager as BaseLinkPager;

/**
* 增加了跳转输入的翻页控件
*/
class LinkPager extends BaseLinkPager
{
    /**
     * Renders the page buttons.
     * @return string the rendering result
     */
    protected function renderPageButtons()
    {
        $pageCount = $this->pagination->getPageCount();
        if ($pageCount < 2 && $this->hideOnSinglePage) {
            return '';
        }

        $buttons = [];
        $currentPage = $this->pagination->getPage();

        // first page
        $firstPageLabel = $this->firstPageLabel === true ? '1' : $this->firstPageLabel;
        if ($firstPageLabel !== false) {
            $buttons[] = $this->renderPageButton($firstPageLabel, 0, $this->firstPageCssClass, $currentPage <= 0, false);
        }

        // prev page
        if ($this->prevPageLabel !== false) {
            if (($page = $currentPage - 1) < 0) {
                $page = 0;
            }
            $buttons[] = $this->renderPageButton($this->prevPageLabel, $page, $this->prevPageCssClass, $currentPage <= 0, false);
        }

        // internal pages
        list($beginPage, $endPage) = $this->getPageRange();
        for ($i = $beginPage; $i <= $endPage; ++$i) {
            $buttons[] = $this->renderPageButton($i + 1, $i, null, false, $i == $currentPage);
        }

        // next page
        if ($this->nextPageLabel !== false) {
            if (($page = $currentPage + 1) >= $pageCount - 1) {
                $page = $pageCount - 1;
            }
            $buttons[] = $this->renderPageButton($this->nextPageLabel, $page, $this->nextPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        // last page
        $lastPageLabel = $this->lastPageLabel === true ? $pageCount : $this->lastPageLabel;
        if ($lastPageLabel !== false) {
            $buttons[] = $this->renderPageButton($lastPageLabel, $pageCount - 1, $this->lastPageCssClass, $currentPage >= $pageCount - 1, false);
        }

        $buttons[] = Html::tag('li', Html::input('number', 'page-jump', $this->pagination->getPage()+1, ['style'=>'width:50px;height:30px;margin-left:4px;border:#ddd solid 1px;text-align:center', 'data-toggle'=>"tooltip", 'data-placement'=>"right", 'title'=>"按回车跳转页码"]));

        $customScript = <<< SCRIPT
$('input[name="page-jump"]').keypress(function(event) {
    if(event.keyCode==13){
        url = window.location.href;
        if(/page=\d+/.test(url)){
            url = url.replace(/page=\d+/gi, 'page='+$(this).val());
        }
        else if(url.indexOf('?')!==-1){
            url = url + '&page='+$(this).val();
        }
        else{
            url = url + '?page='+$(this).val();
        }
        window.location.href=url;
    }
});
SCRIPT;
        $this->view->registerJs($customScript, \yii\web\View::POS_READY);

        return Html::tag('ul', implode("\n", $buttons), $this->options);
    }
}
