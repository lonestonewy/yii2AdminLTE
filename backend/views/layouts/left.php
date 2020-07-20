<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/avatar.png" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..." />
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <?= backend\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget' => "tree"],
                'encodeLabels' => false,
                'items' => [
                    ['label' => '系统首页', 'icon' => 'fa fa-home', 'url' => ['/site/index']],
                    ['label' => '内容运营', 'icon' => 'fa fa-list', 'url' => '#', 'options' => ['class' => 'treeview'], 'items' => [
                        // ['label' => '资讯管理', 'icon' => 'fa fa-list-ol', 'url' => ['/article']],
                        // ['label' => '资讯分类', 'icon' => 'fa fa-list-ol', 'url' => ['/article-category']],
                    ]],
                    
                    ['label' => '系统设置', 'icon' => 'fa fa-cog', 'url' => '#', 'options' => ['class' => 'treeview'], 'items' => [
                        ['label' => '用户管理', 'icon' => 'fa fa-caret-right', 'url' => ['/user']],
                        ['label' => '权限管理', 'icon' => 'fa fa-caret-right', 'url' => ['/rbac'], 'visible' => Yii::$app->user->isAdmin],
                        ['label' => '参数设置', 'icon' => 'fa fa-caret-right', 'url' => ['/config/index']],
                        ['label' => '系统日志', 'icon' => 'fa fa-caret-right', 'url' => ['/log'], 'visible' => Yii::$app->user->isAdmin],
                    ]],
                    [
                        'label' => '开发工具',
                        'icon' => 'fa fa-code',
                        'url' => '#',
                        'visible' => (YII_ENV == 'dev'),
                        'options' => ['class' => 'treeview'],
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'], 'linkOptions' => ['target' => '_blank']],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug']],
                            // [
                            //     'label' => 'Level One',
                            //     'icon' => 'fa fa-circle-o',
                            //     'url' => '#',
                            //     'items' => [
                            //         ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                            //         [
                            //             'label' => 'Level Two',
                            //             'icon' => 'fa fa-circle-o',
                            //             'url' => '#',
                            //             'items' => [
                            //                 ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                            //                 ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                            //             ],
                            //         ],
                            //     ],
                            // ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>