<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace dektrium\rbac\controllers;

use yii;
use yii\rbac\Permission;
use yii\web\NotFoundHttpException;
use yii\rbac\Item;
use dektrium\rbac\components\Generator;
use dektrium\rbac\models\GenerateForm;

/**
 * @author Dmitry Erofeev <dmeroff@gmail.com>
 */
class PermissionController extends ItemControllerAbstract
{
    /** @var string */
    protected $modelClass = 'dektrium\rbac\models\Permission';

    /** @var int */
    protected $type = Item::TYPE_PERMISSION;

    /** @inheritdoc */
    protected function getItem($name)
    {
        $role = \Yii::$app->authManager->getPermission($name);

        if ($role instanceof Permission) {
            return $role;
        }

        throw new NotFoundHttpException;
    }

    public function actionGenerate()
    {
        // Get the generator and authorizer
        $generator = Yii::createObject([
            'class'   => Generator::className(),
        ]);

        // Createh the form model
        $model = new GenerateForm();

        // Form has been submitted
        if( isset($_POST['GenerateForm'])===true )
        {
            // Form is valid
            $model->attributes = $_POST['GenerateForm'];
            if( $model->validate()===true )
            {
                $items = array(
                    'tasks'=>array(),
                    'operations'=>array(),
                );

                // Get the chosen items
                foreach( $model->items as $itemname=>$value )
                {
                    if( (bool)$value===true )
                    {
                        $items['operations'][] = $itemname;
                    }
                }

                // Add the items to the generator as tasks and operations and run the generator.
                $generator->addItems($items['operations']);
                if( ($generatedItems = $generator->run())!==false && $generatedItems!==array() )
                {
                    Yii::$app->getSession()->setFlash('success',
                        '权限项已生成'
                    );
                    return $this->redirect(array('permission/generate'));
                }
            }
        }

        // Get all items that are available to be generated
        $items = $generator->getControllerActions();

        // We need the existing operations for comparason
        $authItems = Yii::$app->authManager->getPermissions();
        $existingItems = array();
        foreach( $authItems as $itemName=>$item )
            $existingItems[ $itemName ] = $itemName;

        // Render the view
        return $this->render('generate', array(
            'model'=>$model,
            'items'=>$items,
            'existingItems'=>$existingItems,
        ));
    }

}