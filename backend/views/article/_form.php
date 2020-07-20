<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
    <?php  $form = ActiveForm::begin([
        'options'=>['class'=>'form-horizontal', 'enctype'=>'multipart/form-data'],
        'fieldConfig'=>[
            'template'=>"{label}\n<div class=\"col-sm-10\">{input}\n{hint}\n{error}</div>",
            'labelOptions'=>['class'=>'col-sm-2 control-label'],
        ],
    ]); ?>
    <?= $form->field($model, 'category_id')->dropdownList(common\models\ArticleCategory::instantiate([])->listData) ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'image')->widget(backend\widgets\FileInput::classname())->hint('支持JPG、PNG格式，不要超过500KB为宜') ?>
    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true])->hint('英文半角逗号隔开多个关键词') ?>
    <?= $form->field($model, 'is_enabled')->radiolist(['1'=>'是', '0'=>'否'], ['itemOptions'=>['class'=>'minimal']]) ?>
    <?= $form->field($model, 'sortnum')->textInput() ?>
    <?= $form->field($model, 'summary')->textarea(['rows' => 5]) ?>
    <?= $form->field($model, 'content')->widget(backend\widgets\CKEditor::classname()) ?>

    <div class="box-footer">
        <a href="javascript:history.back();" class="btn btn-default">取消</a>
        <?=  Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
    </div>
    <?php  ActiveForm::end(); ?>
</div>