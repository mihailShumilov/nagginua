<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
    'basePath'   => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name'       => 'My Console Application',
    // preloading 'log' component
    'preload'    => array('log'),
    'import'     => array(
        'application.models.*',
        'application.components.*',
        'ext.giix-components.*'
    ),
    // application components
    'components' => array(
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
        // uncomment the following to use a MySQL database

        'db'     => array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=parser',
            'emulatePrepare'   => true,
            'username'         => 'root',
            'password'         => '',
            'charset'          => 'utf8',
        ),
        'log'    => array(
            'class'  => 'CLogRouter',
            'routes' => array(
                array(
                    'class'  => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
        'amqp' => array(
            'class' => 'application.components.AMQP.CAMQP',
            'host'     => '127.0.0.1',
            'port'     => '5672',
            'login'    => 'guest',
            'password' => 'guest',
            'vhost'    => '/',
        ),
    ),
    'params'     => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
        'wp'         => array(
            'url'      => 'http://na.loc/api/',
            'login'    => 'admin',
            'password' => 'admin_na'
        )
    ),
);