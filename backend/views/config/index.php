<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '参数设置';
$this->params['breadcrumbs'][] = $this->title;
$weekday = ['日', '一', '二', '三', '四', '五', '六'];
?>
<?php $form = ActiveForm::begin([
    'enableAjaxValidation' => false,
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'options' => ['role' => 'form', 'enctype'=>'multipart/form-data'],
]); ?>
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab_1" data-toggle="tab">基础设置</a></li>
        <li><a href="#tab_2" data-toggle="tab">文本设置</a></li>
        <!-- <li><a href="#tab_3" data-toggle="tab">签到设置</a></li> -->
        <li><a href="#tab_4" data-toggle="tab">提现设置</a></li>
        <li><a href="#tab_5" data-toggle="tab">海报设置</a></li>
        <li><a href="#tab_6" data-toggle="tab">直播设置</a></li>
        <li><a href="#tab_7" data-toggle="tab">功能开关</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab_1">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">应用名称</label>
                    <div class="col-lg-9">
                        <input type="text" name="app_name" class="form-control" value="<?php echo $config['app_name'] ?>">
                        <p class="help-block">显示在微信标题、分享等</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">LOGO</label>
                    <div class="col-lg-6">
                        <?php echo backend\widgets\FileInput::widget(['name'=>'app_icon', 'value'=>$config['app_icon']]) ?>
                            <?php if($config['app_icon']):?><p><img src="<?=$config['app_icon']?>" height="120"></p><?php endif;?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">版权申明</label>
                    <div class="col-lg-9">
                        <input type="text" name="copyright" class="form-control" value="<?php echo $config['copyright'] ?>">
                        <p class="help-block">显示在页面底部的版权所有信息</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">应用描述</label>
                    <div class="col-lg-9">
                        <input type="text" name="app_desc" class="form-control" value="<?php echo $config['app_desc'] ?>">
                        <p class="help-block">主要用于微信分享</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">应用口号</label>
                    <div class="col-lg-9">
                        <input type="text" name="app_slogan" class="form-control" value="<?php echo $config['app_slogan'] ?>">
                        <p class="help-block">显示在分享二维码下面</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">热线电话</label>
                    <div class="col-lg-9">
                        <input type="text" name="service_phone" class="form-control" value="<?php echo $config['service_phone'] ?>">
                        <p class="help-block">主要用于微信会员中心等处的客服</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">短信签名</label>
                    <div class="col-lg-9">
                        <input type="text" name="sms_sign" class="form-control" value="<?php echo $config['sms_sign'] ?>">
                        <p class="help-block">短信签名需要实现备案审批，请联系客服人员，可使用默认签名“拓客云课堂”</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">短信验证码模板ID</label>
                    <div class="col-lg-9">
                        <input type="text" name="sms_reg_templateid" class="form-control" value="<?php echo $config['sms_reg_templateid'] ?>">
                        <p class="help-block">请在阿里云短信服务后台获取“用户注册验证码”的模板ID</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">页底文字</label>
                    <div class="col-lg-9">
                        <input type="text" name="no_more_text" class="form-control" value="<?php echo $config['no_more_text'] ?>">
                        <p class="help-block">页面到底后显示的提示文字</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">轮播分组</label>
                    <div class="col-lg-9">
                        <input type="text" name="carousel_groups" class="form-control" value="<?php echo $config['carousel_groups'] ?>">
                        <p class="help-block">多个分组用英文逗号分开即可。</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">服务费比例</label>
                    <div class="col-lg-9">
                        <input type="number" step="0.01" min="0" max="0.99" name="service_fee_rate" class="form-control" value="<?php echo $config['service_fee_rate'] ?>">
                        <p class="help-block">如0.3表示系统收服务费30%</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">员工邀请码</label>
                    <div class="col-lg-9">
                        <input type="number" min="1000000" name="invite_code" class="form-control" value="<?php echo $config['invite_code'] ?>">
                        <p class="help-block">用于发展员工，使用此邀请码注册自动成为员工</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">合伙人邀请码</label>
                    <div class="col-lg-9">
                        <input type="number" min="1000000" name="partner_invite_code" class="form-control" value="<?php echo $config['partner_invite_code'] ?>">
                        <p class="help-block">用于发展合伙人，使用此邀请码注册自动成为合伙人</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">会员注册</label>
                    <div class="col-lg-9">
                        <?= Html::radioList('member_register_enabled', $config['member_register_enabled'], ['1' => '开通', '0' => '关闭'], ['itemOptions' => ['class' => 'minimal']]) ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">话题红包</label>
                    <div class="col-lg-9">
                        <?= Html::radioList('redpack_enabled', $config['redpack_enabled'], ['1' => '开通', '0' => '关闭'], ['itemOptions' => ['class' => 'minimal']]) ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button type="submit" class="btn btn-sm btn-primary">保存设置</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_2">
            <div class="box-body">
                <!-- <div class="form-group">
                <label class="col-lg-3 control-label">推荐成功模板消息</label>
                <div class="col-lg-9">
                    <input type="text" name="app_template_msg" class="form-control" value="<?php echo $config['app_template_msg'] ?>">
                </div>
            </div> -->
                <div class="form-group">
                    <label class="col-lg-3 control-label">邀请规则</label>
                    <div class="col-lg-9">
                        <?php echo backend\widgets\CKEditor::widget(['name' => 'invite_rules', 'value' => $config['invite_rules']]) ?>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">学员权益</label>
                    <div class="col-lg-9">
                        <?php echo backend\widgets\CKEditor::widget(['name' => 'member_rights', 'value' => $config['member_rights']]) ?>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">关于我们</label>
                    <div class="col-lg-9">
                        <?php echo backend\widgets\CKEditor::widget(['name' => 'about_us', 'value' => $config['about_us']]) ?>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">联系我们</label>
                    <div class="col-lg-9">
                        <?php echo backend\widgets\CKEditor::widget(['name' => 'contact_us', 'value' => $config['contact_us']]) ?>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">退货说明</label>
                    <div class="col-lg-9">
                        <textarea name="refund_remark" rows="5" class="form-control"><?=$config['refund_remark']?></textarea>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button type="submit" class="btn btn-sm btn-primary">保存设置</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tab-pane -->
       
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_4">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">最低提现金额</label>
                    <div class="col-lg-3">
                        <input type="text" name="min_settle_amount" class="form-control" value="<?php echo $config['min_settle_amount'] ?>">
                    </div>
                    <div class="col-lg-1">
                        <p class="help-block">元</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">最短提现周期</label>
                    <div class="col-lg-3">
                        <input type="text" name="min_settle_interval" class="form-control" value="<?php echo $config['min_settle_interval'] ?>">
                    </div>
                    <div class="col-lg-1">
                        <p class="help-block">天</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">提现到微信钱包</label>
                    <div class="col-lg-9">
                        <?= Html::radioList('settle_to_wechat_balance', $config['settle_to_wechat_balance'], ['1' => '开通', '0' => '关闭'], ['itemOptions' => ['class' => 'minimal']]) ?>
                        <p class="help-block">需开通企业付款到零钱功能后再开启该功能，否则会无法提现。</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">提现手续费率</label>
                    <div class="col-lg-3">
                        <input type="text" name="settle_fee" class="form-control" value="<?php echo $config['settle_fee'] ?>">
                    </div>
                    <div class="col-lg-3">
                        <p class="help-block">填写0到1的小数，如0.05表示5%</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">提现时间限制</label>
                    <div class="col-lg-9">
                        <select name="settle_weekday" class="form-control select2" value="<?php echo $config['settle_weekday'] ?>">
                            <?php for ($index = 0; $index < 7; $index++) : ?>
                                <option <?php if ($config['settle_weekday'] == $index) echo 'selected' ?> value="<?= $index ?>"><?= $weekday[$index] ?></option>
                            <?php endfor ?>
                        </select>
                        <select name="settle_hour_start" class="form-control select2" value="<?php echo $config['settle_hour_start'] ?>">
                            <?php for ($index = 0; $index < 24; $index++) : ?>
                                <option <?php if ($config['settle_hour_start'] == $index) echo 'selected' ?> value="<?= $index ?>"><?= $index ?>:00</option>
                            <?php endfor ?>
                        </select>
                        到
                        <select name="settle_hour_end" class="form-control select2" value="<?php echo $config['settle_hour_end'] ?>">
                            <?php for ($index = 0; $index < 24; $index++) : ?>
                                <option <?php if ($config['settle_hour_end'] == $index) echo 'selected' ?> value="<?= $index ?>"><?= $index ?>:00</option>
                            <?php endfor ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">提现条款</label>
                    <div class="col-lg-9">
                        <?php echo backend\widgets\CKEditor::widget(['name' => 'settle_terms', 'value' => $config['settle_terms']]) ?>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button type="submit" class="btn btn-sm btn-primary">保存设置</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tab-pane -->

        <div class="tab-pane" id="tab_5">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">会员推广码模板</label>
                    <div class="col-lg-6">
                        <?php echo backend\widgets\FileInput::widget(['name'=>'poster_default_tpl', 'value'=>$config['poster_default_tpl']]) ?>
                            <?php if($config['poster_default_tpl']):?><p><img src="<?=$config['poster_default_tpl']?>" height="200"></p><?php endif;?>
                        <p class="help-block">请在相应位置预留好头像、二维码的位置，坐标在下面配置；未上传自定义模板的课程、专栏、产品、话题和直播等，也将采用这个模板 <a href="/files/poster_tpl.psd">海报示例下载</a></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">头像大小</label>
                    <div class="col-lg-3">
                        <input type="text" name="poster_avatar_size" class="form-control" value="<?php echo $config['poster_avatar_size'] ?>">
                    </div>
                    <div class="col-lg-1">
                        <p class="help-block">像素</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">头像坐标</label>
                    <div class="col-lg-3">
                        <input type="text" name="poaster_avatar_cord" class="form-control" value="<?php echo $config['poaster_avatar_cord'] ?>">
                    </div>
                    <div class="col-lg-1">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">小程序码大小</label>
                    <div class="col-lg-3">
                        <input type="text" name="poster_appcode_size" class="form-control" value="<?php echo $config['poster_appcode_size'] ?>">
                    </div>
                    <div class="col-lg-1">
                        <p class="help-block">像素</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">小程序码坐标</label>
                    <div class="col-lg-3">
                        <input type="text" name="poster_appcode_cord" class="form-control" value="<?php echo $config['poster_appcode_cord'] ?>">
                    </div>
                    <div class="col-lg-1">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button type="submit" class="btn btn-sm btn-primary">保存设置</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tab-pane -->

        <div class="tab-pane" id="tab_6">
            <div class="box-body">
                <div class="form-group">
                    <label class="col-lg-3 control-label">阿里云 AccessKey ID</label>
                    <div class="col-lg-3">
                        <input type="text" name="aliyun_accesskey_id" class="form-control" value="<?php echo $config['aliyun_accesskey_id'] ?>">
                    </div>
                    <div class="col-lg-6">
                        <p class="help-block">需开通直播和OSS服务全部权限</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">阿里云 AccessKey Secret</label>
                    <div class="col-lg-3">
                        <input type="text" name="aliyun_accesskey_secret" class="form-control" value="<?php echo $config['aliyun_accesskey_secret'] ?>">
                    </div>
                    <div class="col-lg-6">
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">直播推流和播流域名</label>
                    <div class="col-lg-3">
                        <input type="text" name="aliyun_live_domain" class="form-control" value="<?php echo $config['aliyun_live_domain'] ?>">
                    </div>
                    <div class="col-lg-6">
                        <p class="help-block">必须是顶级域名</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">域名注册于同账号阿里云</label>
                    <div class="col-lg-2">
                        <?= Html::radioList('aliyun_domain_hosted', $config['aliyun_domain_hosted'], ['1' => '是', '0' => '否'], ['itemOptions' => ['class' => 'minimal']]) ?>
                    </div>
                    <div class="col-lg-7">
                        <p class="help-block">若勾选则需要域名管理权限，以便自动配置CNAME</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">直播打赏开启</label>
                    <div class="col-lg-2">
                        <?= Html::radioList('live_reward_enabled', $config['live_reward_enabled'], ['1' => '是', '0' => '否'], ['itemOptions' => ['class' => 'minimal']]) ?>
                    </div>
                    <div class="col-lg-7">
                        <p class="help-block">若开启请设置下面的分成比例</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">直播打赏主播分成比例</label>
                    <div class="col-lg-2">
                        <input type="number" min="0" max="1" step="0.01" name="live_reward_rate" class="form-control" value="<?php echo $config['live_reward_rate'] ?>">
                    </div>
                    <div class="col-lg-7">
                        <p class="help-block">填写0到1的小数，如0.05表示5%，为分给主播的部分比例</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button type="submit" class="btn btn-sm btn-primary">保存设置</button>
                        <a href="<?=Url::to(['live-config'])?>" class="btn btn-sm btn-default">立即配置</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tab-pane -->
        <div class="tab-pane" id="tab_7">
            <div class="box-body">
            <div class="form-group">
                    <label class="col-lg-3 control-label">专栏开启</label>
                    <div class="col-lg-2">
                        <?= Html::radioList('column_enabled', $config['column_enabled'], ['1' => '是', '0' => '否'], ['itemOptions' => ['class' => 'minimal']]) ?>
                    </div>
                    <div class="col-lg-7">
                        <p class="help-block">小程序提交审核期间可以关闭专栏，开启后1小时内生效</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">讨论开启</label>
                    <div class="col-lg-2">
                        <?= Html::radioList('topic_enabled', $config['topic_enabled'], ['1' => '是', '0' => '否'], ['itemOptions' => ['class' => 'minimal']]) ?>
                    </div>
                    <div class="col-lg-7">
                        <p class="help-block">小程序提交审核期间可以关闭讨论，开启后1小时内生效</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">直播开启</label>
                    <div class="col-lg-2">
                        <?= Html::radioList('live_enabled', $config['live_enabled'], ['1' => '是', '0' => '否'], ['itemOptions' => ['class' => 'minimal']]) ?>
                    </div>
                    <div class="col-lg-7">
                        <p class="help-block">小程序提交审核期间可以关闭直播，开启后1小时内生效</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">短视频开启</label>
                    <div class="col-lg-2">
                        <?= Html::radioList('shortvideo_enabled', $config['shortvideo_enabled'], ['1' => '是', '0' => '否'], ['itemOptions' => ['class' => 'minimal']]) ?>
                    </div>
                    <div class="col-lg-7">
                        <p class="help-block">小程序提交审核期间可以关闭短视频，开启后1小时内生效</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <button type="submit" class="btn btn-sm btn-primary">保存设置</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tab-pane -->

    </div>
    <!-- /.tab-content -->
</div>
<?php ActiveForm::end(); ?>