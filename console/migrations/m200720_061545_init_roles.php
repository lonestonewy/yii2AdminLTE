<?php

use yii\db\Migration;

/**
 * Class m200720_061545_init_roles
 */
class m200720_061545_init_roles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('Admin');
        $admin->description = '超级管理员';
        $auth->add($admin);
        $auth->assign($admin, 1);

        $sitePermissions = $auth->createPermission('Site.*');
        $sitePermissions->description = '基础权限';
        $auth->add($sitePermissions);

        $auth->addChild($admin, $sitePermissions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200720_061545_init_roles cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200720_061545_init_roles cannot be reverted.\n";

        return false;
    }
    */
}
