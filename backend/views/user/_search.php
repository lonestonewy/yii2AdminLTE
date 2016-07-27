<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-xs-12">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
            'options'=>['class'=>'form-inline'],
            'fieldConfig'=>[
                'template'=>"{label}\n{input}\n",
                'labelOptions'=>['class'=>'sr-only'],
            ],
        ]); ?>

        <?= $form->field($model, 'id')->textInput(['placeholder'=>'ID']) ?>
        <?= $form->field($model, 'username')->textInput(['placeholder'=>'用户名']) ?>
        <?= $form->field($model, 'email')->textInput(['placeholder'=>'Email']) ?>
        <?= $form->field($model, 'status')->dropdownList([User::STATUS_ACTIVE=>'正常', User::STATUS_DELETED=>'已禁用'], ['prompt'=>'', 'data-placeholder'=>'状态', 'class'=>'form-control select2', 'style'=>'width:120px']) ?>
        <?php // echo $form->field($model, 'created_at') ?>
        <?php // echo $form->field($model, 'updated_at') ?>

        <div class="form-group">
            <?= Html::submitButton('<i class="fa fa-search"></i>', ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
