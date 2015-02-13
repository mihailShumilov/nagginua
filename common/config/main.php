<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'ru-RU',

    'components' => [

        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'db' => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'pgsql:host=localhost;dbname=nagg',
            'username' => 'nagg',
            'password' => '6cNQBF@vZ|ebZu,K4h',
            'charset'  => 'utf8',
        ],
    ],
];
