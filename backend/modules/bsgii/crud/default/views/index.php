<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();
$model = new $generator->modelClass;

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;

/* @var $this yii\web\View */
<?= !empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '<?php echo $model->modelName ?>管理';
$this->params['breadcrumbs'][] = $this->title;

$dataProvider->pagination->pageSize=10;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">
<div class="ibox-title">
    <!-- <h5><?php echo "<?php"; ?> echo $this->title ?></h5> -->
    <div class="ibox-tools">
        <?php echo "<?php"; ?> echo Html::a('<i class="fa fa-edit"></i> 新增', ['create']); ?>
        <!--
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-wrench"></i> 其他
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="#">Config option 1</a>
            </li>
            <li><a href="#">Config option 2</a>
            </li>
        </ul>
        -->
    </div>
</div>
        <div class="ibox-content" style="padding-bottom:0">
        <?php if(!empty($generator->searchModelClass)): ?>
        <?= "    <?php " ?>echo $this->render('_search', ['model' => $searchModel]); ?>
        <?php endif; ?>
        </div>
        <div class="ibox-content">
<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'pager'=>['class'=>'backend\widgets\LinkPager'],
        'dataProvider' => $dataProvider,
        'summary'=>'第{page}页，共{pageCount}页，当前第{begin}-{end}条，共{totalCount}条数据.',
        'tableOptions' => ['class'=>'table table-striped table-hover'],
        'layout' => '<div class="table-responsive">{items}</div><div class="row"><div class="col-md-7">{pager}</div><div class="col-md-5 text-right">{summary}</div></div>',
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "            '" . $name . "',\n";
        } else {
            echo "            // '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "            // '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'summary'=>'第{page}页，共{pageCount}页，当前第{begin}-{end}条，共{totalCount}条数据.',
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]) ?>
<?php endif; ?>

    </div>
</div>
