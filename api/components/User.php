<?php
namespace api\components;
use yii;
use yii\web\User as BaseUser;

class User extends BaseUser
{
    // 当前用户是否是管理员
    public function getIsAdmin()
    {
        return Yii::$app->authManager->checkAccess($this->id, 'Admin');
    }

    public function isRole($name)
    {
        return Yii::$app->authManager->checkAccess($this->id, $name);
    }

     /**
     * 得到当前用户的角色名称
     * @return string
     */
    public function getRoleNames()
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->isAdmin) {
            return '超级管理员';
        }

        $roles = Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);

        $names = [];
        foreach($roles as $role)
        {
            $names[$role->name] = $role->description ? $role->description : $role->name;
        }

        return implode('/', $names);
    }
}