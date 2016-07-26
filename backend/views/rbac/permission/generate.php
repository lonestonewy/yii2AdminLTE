<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = '权限';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $this->beginContent('@dektrium/rbac/views/layout.php') ?>
<div class="alert alert-info">请选择要生成的权限项，再点击生成按钮，即可批量生成授权项。</div>
<div class="panel panel-default">
  <div class="panel-body">

<div class="row">
    <div class="col-xs-12">
<div id="generator">


	<div class="form">

		<?php $form = ActiveForm::begin(); ?>


				<table class="items generate-item-table table  table-striped" border="0" cellpadding="0" cellspacing="0">

					<tbody>

						<tr class="application-heading-row">
                            <th>选择</th>
                            <th>授权项</th>
							<th>源程序位置</th>
						</tr>

						<?php echo $this->render('_generateItems', array(
							'model'=>$model,
							'form'=>$form,
							'items'=>$items,
							'existingItems'=>$existingItems,
							'displayModuleHeadingRow'=>true,
							'basePathLength'=>strlen(Yii::$app->basePath),
						)); ?>

					</tbody>

				</table>

                <div class="col-sm-1">
                <?php echo Html::submitButton('生成', ['class' => 'btn btn-success btn-block']); ?>
            </div>
			<div class="col-sm-11">

   				<?php echo Html::a('全选', '#', array(
   					'onclick'=>"jQuery('.generate-item-table').find(':checkbox').attr('checked', 'checked'); return false;",
   					'class'=>'selectAllLink')); ?>
   				/
				<?php echo Html::a('全不选', '#', array(
					'onclick'=>"jQuery('.generate-item-table').find(':checkbox').removeAttr('checked'); return false;",
					'class'=>'selectNoneLink')); ?>

			</div>



		 <?php ActiveForm::end(); ?>

	</div>

</div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(function() {
    //jQuery('.generate-item-table').rightsSelectRows();
});
</script>
<?php $this->endContent() ?>