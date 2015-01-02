<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'language' => 'ru-RU',

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
