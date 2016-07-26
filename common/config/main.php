<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'traceLevel' => 3,
            'targets' => [
                'app'=>[
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'logVars'=>['_GET', '_POST', '_SESSION'],
                    'except'=>[
                        'api',
                        'yii\base\UserException',
                        'yii\db\*',
                    ],
                ],
                'email'=>[
                    'class' => 'yii\log\EmailTarget',
                    'mailer' => 'mailer',
                    'levels' => ['error'],
                    'except'=> [
                        'yii\base\UserException',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:403',
                        'common\base\*',
                    ],
                    'logVars'=>['_GET', '_POST', '_SESSION'],
                    'message' => [
                        'from' => ['lonestone@qq.com'],
                        'to' => ['lonestone@qq.com'],
                        'subject' => '【VRSITE】错误日志邮件通知',
                    ],
                ],
                'db'=>[
                    'class' => 'yii\log\DbTarget',
                    'levels' => ['error', 'warning'],
                    'logVars'=>['_GET', '_POST', '_SESSION'],
                    'except'=> [
                        'yii\base\UserException',
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:400',
                        'yii\web\HttpException:403',
                        'common\base\*',
                    ],
                ],
            ],
        ],
    ],
];
