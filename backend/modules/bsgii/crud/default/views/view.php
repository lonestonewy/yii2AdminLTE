<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();
$model = new $generator->modelClass;
echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = '<?php echo $model->modelName ?>详情 '.$model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => '<?php echo $model->modelName ?>', 'url' => ['index']];
$this->params['breadcrumbs'][] = '<?php echo $model->modelName ?>详情';
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-view">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $model->modelName ?>详情</h5>
            <div class="ibox-tools">
                <?= "<?= " ?>Html::a('<i class="fa fa-edit"></i> 修改', ['update', <?= $urlParams ?>]) ?>
                <?= "<?= " ?>Html::a('<i class="fa fa-trash-o"></i> 删除', ['delete', <?= $urlParams ?>], [
                    'data' => [
                        'confirm' => '您确定要删除这个项目吗？',
                        'method' => 'post',
                    ]
                ]) ?>
                <a class="close-link" href="<?= "<?= " ?> Url::toRoute(['index']) ?>">
                    <i class="fa fa-undo"></i> 返回
                </a>
            </div>
        </div>
        <div class="ibox-content">

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="20%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
<?php
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        echo "            '" . $name . "',\n";
    }
} else {
    foreach ($generator->getTableSchema()->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        echo "            '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
    }
}
?>
        ],
    ]) ?>

        </div>
    </div>
</div>
