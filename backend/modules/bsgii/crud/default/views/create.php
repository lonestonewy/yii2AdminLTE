<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
$model = new $generator->modelClass;
/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = '新增<?php echo $model->modelName ?>';
$this->params['breadcrumbs'][] = ['label' => '<?php echo $model->modelName ?>管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = '新增';
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">
    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
