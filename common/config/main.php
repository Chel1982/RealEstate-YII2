<?php
return [
    'name' => 'Real Estate',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [

        'db' => require(dirname(__DIR__)."/config/db.php"),

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
];
