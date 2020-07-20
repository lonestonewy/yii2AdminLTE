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
 * @var $this yii\web\View
 */

use yii\bootstrap\Nav;

?>

<?= Nav::widget([
    'options' => [
        'class' => 'nav-tabs'
    ],
    'activateParents' =>true,
    'items' => [
        [
            'label'   => Yii::t('rbac', 'Users'),
            'url'     => ['/user/admin/index'],
            'visible' => isset(Yii::$app->extensions['dektrium/yii2-user']),
        ],
        [
            'label' => Yii::t('rbac', 'Roles'),
            'url'   => ['/rbac/role/index'],
            'active'=> $this->context->id == 'role',
        ],
        [
            'label' => Yii::t('rbac', 'Permissions'),
            'url'   => ['/rbac/permission/index'],
            'active'=> $this->context->id == 'permission',
        ],
        [
            'label' => Yii::t('rbac', 'Create'),
            'options' => [
                'class' => 'pull-right'
            ],
            'active'=> false,
            'items' => [
                [
                    'label'   => Yii::t('rbac', 'New user'),
                    'url'     => ['/user/admin/create'],
                    'visible' => isset(Yii::$app->extensions['dektrium/yii2-user']),
                ],
                [
                    'label' => Yii::t('rbac', 'New role'),
                    'url'   => ['/rbac/role/create']
                ],
                [
                    'label' => Yii::t('rbac', 'New permission'),
                    'url'   => ['/rbac/permission/create']
                ],
                [
                    'label' => Yii::t('rbac', '批量生成'),
                    'url'   => ['/rbac/permission/generate']
                ]
            ]
        ]
    ]
]) ?>
