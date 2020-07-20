<?php

namespace api\modules\v1\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use common\components\ActiveRecord;
use common\components\behaviors\DatetimeBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\httpclient\Client;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 */
class User extends \common\models\User
{
    
    public function fields()
    {
        $fields = parent::fields();
        $fields['statistics'] = function($model){
            return $model->getStatistics();
        };        
        return $fields;
    }
}
