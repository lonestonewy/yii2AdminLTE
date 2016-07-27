<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

$attributes= $generator->getColumnNames();
echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use kartik\builder\Form;
use kartik\builder\FormGrid;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">

<div class="row">
<div class="col-lg-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5><?php echo $this->title ?></h5>
            <div class="ibox-tools">
                <a class="close-link" href="<?php echo '<?php echo'; ?> Url::toRoute(['index']) ?>">
                    <i class="fa fa-undo"></i> 返回
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="user-form">
<?= "<?php " ?>  
$form = ActiveForm::begin(['options'=>['enctype'=>'multipart/form-data']]);
echo FormGrid::widget([
    'model' => $model,
    'form' => $form,
    'columns'=>2,
    'autoGenerateColumns' => false,
    'rows' => [
        [
            'attributes' => [
                <?php $key=0; foreach ($attributes as $attribute) {
                    if (in_array($attribute, $safeAttributes)) {
                        echo '                '.$generator->generateActiveGridField($attribute) . "\n";
                        $key ++;
                    }
                } ?>
            ],
        ],
    ]
]);
?>
<div class="hr-line-dashed"></div>
<div class="row">
    <div class="col-sm-12" style="text-align:right">
        <?= "<?= " ?>Html::submitButton($model->isNewRecord ? <?= $generator->generateString('新增') ?> : <?= $generator->generateString('更新') ?>, ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
</div>
<?= "<?php " ?>
ActiveForm::end();
?>
            </div>
        </div>
    </div>
</div>
