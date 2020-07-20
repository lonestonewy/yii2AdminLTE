<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Log */

$this->title = '系统日志详情 '.$model->id;
$this->params['breadcrumbs'][] = ['label' => '系统日志', 'url' => ['index']];
$this->params['breadcrumbs'][] = '系统日志详情';
?>

<div class="box">
    <div class="box-header">
    <div class="pull-right">
        <?=  Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default']) ?>
    </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <?= DetailView::widget([
        'model' => $model,
        'template' => '<tr><th width="20%">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            'level',
            'category',
            'log_time',
            'prefix:ntext',
            'message:ntext',
        ],
    ]) ?>

    </div>
    <!-- /.box-body -->
</div>