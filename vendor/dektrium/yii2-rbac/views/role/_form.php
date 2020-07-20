<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this  yii\web\View
 * @var $model dektrium\rbac\models\Role
 */

// use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\helpers\Url;

Yii::$app->params['role_children'] = $model->children;
?>
<div class="alert alert-info">超级管理员Admin角色不需要授予任何权限，授予了带*号的项目后，就无需再授予该权限下的子权限了。</div>

<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
    'enableAjaxValidation'   => true,
]) ?>

<?= $form->field($model, 'name') ?>

<?= $form->field($model, 'description') ?>

<?= $form->field($model, 'rule') ?>

<?php
//  $form->field($model, 'children')->widget(Select2::className(), [
//     'data' => $model->getUnassignedItems(),
//     'options' => [
//         'id' => 'children',
//         'multiple' => true
//     ],
// ]) ?>
<div class="form-group field-role-rule">
<label for="role-rule" class="control-label">授权项</label>
<?= GridView::widget([
    'dataProvider' => $model->getUnassignedItemsDataProvider(),
    'filterModel'  => $filterModel,
    'layout'       => "{items}\n{pager}",
    'columns'      => [
        [
            'class' => CheckboxColumn::className(),
            'name'=>'Role[children][]',
            'checkboxOptions' => function ($model, $key, $index, $column) {
                return ['value' => $model['name'], 'checked'=>in_array($model['name'], Yii::$app->params['role_children'])];
            },
            'options'   => [
                'style' => 'width: 40px'
            ],
        ],
        [
            'attribute' => 'name',
            'header'    => Yii::t('rbac', 'Name'),
            'options'   => [
                'style' => 'width: 20%'
            ],
        ],
        [
            'attribute' => 'description',
            'header'    => Yii::t('rbac', 'Description'),
        ],
    ],
]) ?>
</div>
<?= Html::submitButton(Yii::t('rbac', 'Save'), ['class' => 'btn btn-success btn-block']) ?>

<?php ActiveForm::end() ?>