<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

$this->registerJsFile('/js/moment.min.js', ['position'=>\yii\web\View::POS_HEAD]);
if (Yii::$app->controller->action->id === 'login') {
/**
 * Do not use this code in your template. Remove it.
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {
    backend\assets\AppAsset::register($this);
    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    // $this->registerJsFile($directoryAsset.'/js/demo.js', ['depends'=>'backend\assets\AdminLteAsset']);

    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="renderer" content="webkit">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
         <!--[if lt IE 9]>
        <style type="text/css">
        #ie-warning{background:rgb(255,255,225) no-repeat scroll 8px center;position:absolute;top:0;left:0;font-size:12px;color:#333;width:100%;padding: 2px 15px 2px 23px;text-align:center;}
        #ie-warning a {text-decoration:none;}
        body {padding-top:20px}
        </style>
        <script src="//cdn.bootcss.com/html5shiv/3.7.3/html5shiv-printshiv.min.js"></script>
        <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php $this->head() ?>
        <script>
          var AdminLTEOptions = {
            //Enable sidebar expand on hover effect for sidebar mini
            //This option is forced to true if both the fixed layout and sidebar mini
            //are used together
            sidebarExpandOnHover: false,
            //BoxRefresh Plugin
            enableBoxRefresh: true,
            //Bootstrap.js tooltip
            enableBSToppltip: true,
            //'fast', 'normal', or 'slow'
            animationSpeed: 'fast'
          };
        </script>
    </head>
    <body class="hold-transition skin-black-light sidebar-mini fixed">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>

    <?php $this->endBody() ?>
    <!--[if lte IE 8]>
    <div id="ie-warning">
    您正在使用低版本的 IE浏览器（或基于IE，如360、遨游等），低版本的IE浏览器会因为技术淘汰而无法正常使用平台，如果出现页面错乱或者功能失常，请<a href="http://chrome.360.cn" target="_blank">点击这里下载安装360极速浏览器</a>。
    </div>
    <![endif]-->
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
