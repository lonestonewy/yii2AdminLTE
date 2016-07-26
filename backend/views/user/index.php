<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <!-- Check all button -->
                <!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> -->
                <div class="btn-group">
                    <?= Html::a('<i class="fa fa-pencil-square-o"></i>', ['create'], ['class' => 'btn btn-default btn-sm']) ?>
                </div>
                <!-- /.btn-group -->
                <a type="button" class="btn btn-default btn-sm" href="javascript:window.location.reload()"><i class="fa fa-refresh"></i></a>
                <div class="pull-right">
                    <!-- <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div> -->
                    <?php echo $this->render('_search', [
                        'model' => $searchModel,
                    ]); ?>
                    <!-- /.btn-group -->
                </div>
                <!-- /.pull-right -->
            </div>
            <!-- /.box-header -->
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => "<div class=\"box-body table-responsive no-padding\">{items}</div>\n<div class=\"box-footer clearfix\">{summary}{pager}</div>",
                'tableOptions'=>['class'=>'table table-hover'],
                'filterModel'=>null,
                'pager'=>[
                    'class'=>'common\components\LinkPager',
                    'options' => ['class' => 'pagination pagination-sm no-margin pull-right'],
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'id',
                    'username',
                    // 'auth_key',
                    // 'password_hash',
                    // 'password_reset_token',
                    'email:email',
                    'status',
                    'created_at',
                    // 'updated_at',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
