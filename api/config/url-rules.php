<?php
return [
    'wechat/index/<appid:\w+>' => 'wechat/index',
    [
        'class' => 'yii\rest\UrlRule', 'prefix' => '<appid:wx\w+>', 'controller' => [
            'v1/user', 
        ],
        'extraPatterns' => [
            'GET,POST <id:\d+>/<action:.+?>' => '<action>',//对单个对象的操作
            'GET,POST <action:[a-z\-]+?>' => '<action>',//自定义get方法
        ],
    ],
    '<appid:wx\w+>/<version:v\d+?>/<controller:.+>/<action:.+>' => '<version>/<controller>/<action>',
];
