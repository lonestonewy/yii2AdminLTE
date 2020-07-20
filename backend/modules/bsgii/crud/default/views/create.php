<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

$model = new $generator->modelClass;
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */
$modelClassName = substr($generator->modelClass, strrpos($generator->modelClass, '\\')+1);

echo "<?php\n";
?>

use yii\helpers\Html;
use <?php echo $generator->modelClass ?>;


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = '新增'.<?= $modelClassName ?>::$modelName;
$this->params['breadcrumbs'][] = ['label' => <?= $modelClassName ?>::$modelName.'管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '新增';
?>
<div class="box box-info">
    <div class="box-header">
        <div class="pull-right">
            <?= "<?= " ?> Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default', 'data-dismiss'=>'modal']) ?>
        </div>
    </div>
    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
