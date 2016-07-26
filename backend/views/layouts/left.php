<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->username ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => '内容管理', 'icon' => 'fa fa-list', 'url' => '#', 'items'=>[
                        ['label' => '资讯管理', 'icon' => 'fa fa-newspaper-o', 'url' => ['/news/index']],
                    ]],
                    ['label' => '系统设置', 'icon' => 'fa fa-cog', 'url' => '#', 'items'=>[
                        ['label' => '权限管理', 'icon' => 'fa fa-lock', 'url' => ['/rbac'], 'visible' => Yii::$app->user->isAdmin],
                        ['label' => '用户管理', 'icon' => 'fa fa-users', 'url' => ['/user/index']],
                    ]],
                    [
                        'label' => '开发工具',
                        'icon' => 'fa fa-code',
                        'url' => '#',
                        'visible'=> (YII_ENV == 'dev'),
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
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
