<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '直播配置';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box">
    <div class="box-header">
        <h3 class="box-title"><?= $steps[$step] ?></h3>
        <!-- /.btn-group -->
        <div class="pull-right">
            <?= Html::a('<i class="fa fa-reply"></i>', ['index'], ['class' => 'btn btn-default']) ?>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="resultinfo" class="alert alert-info alert-dismissible">
            <p>请点击按钮开始<?= $steps[$step] ?></p>
        </div>
        <div id="progressBar" style=" width: 100%; height: 100px;"></div>
    </div>
    <div class="box-footer">
        <a data-dismiss="modal" href="javascript:history.back();" class="btn btn-default">取消</a>
        <div class="btn-group pull-right">
            <?= Html::submitButton('开始', ['id' => 'btn-submit', 'class' => 'btn btn-success']) ?>
            <?= Html::submitButton('跳过', ['id' => 'btn-next', 'class' => 'btn btn-primary', 'style' => 'display:none']) ?>
        </div>
    </div>
    <!-- /.box-body -->
</div>

<script type="text/javascript">
    var $progressDiv = $("#progressBar");
    var $progressBar = $progressDiv.progressStep();
    var $step_keys = <?=$step_keys?>;
    var $currentStep = $step_keys.indexOf('<?= $steps[$step] ?>');
    for (let index = 0; index < $step_keys.length; index++) {
        const element = $step_keys[index];
        $progressBar.addStep(element);
    }
    $progressBar.setCurrentStep($currentStep);
    $progressBar.refreshLayout();

    var step = '<?= $step ?>';
    var next_step = '';
    $(document).ready(function() {
        $('#btn-submit').click(function() {
            var $that = $(this);
            $that.attr('disabled', true).addClass('btn-disabled');
            $that.text('正在处理...');
            var jqxhr = $.post("<?= Url::to(['init-live-config', 'step' => '']) ?>" + step, function(data) {
                    next_step = data.next_step;
                    if (data.success === true) {
                        $('#resultinfo>p').html(data.message);
                        $that.hide();
                        $('#btn-next').text('下一步');
                        $('#btn-next').show();
                    } else {
                        $('#resultinfo>p').html(data.message);
                        $that.text('重试');
                        $('#btn-next').show();
                    }

                    if(!next_step){
                        $('#btn-next').attr('disabled', true).addClass('btn-disabled').text('已全部配置完成').show();
                    }
                })
                .always(function() {
                    $that.attr('disabled', false).removeClass('btn-disabled');
                });
        });

        $('#btn-next').click(function() {
            window.location.href="<?= Url::to(['live-config', 'step' => '']) ?>"+next_step;
        });
    });
</script>