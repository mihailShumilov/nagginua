<?php
    $params = array_merge(
        require( __DIR__ . '/../../common/config/params.php' ),
        require( __DIR__ . '/../../common/config/params-local.php' ),
        require( __DIR__ . '/params.php' ),
        require( __DIR__ . '/params-local.php' )
    );

    return [
        'id'                  => 'app-api',
        'basePath'            => dirname( __DIR__ ),
        'controllerNamespace' => 'api\controllers',
        'bootstrap'           => [ 'log' ],
        'components'          => [
            'user'         => [
                'identityClass'   => 'common\models\User',
                'enableAutoLogin' => true,
            ],
            'log'          => [
                'traceLevel' => YII_DEBUG ? 3 : 0,
                'targets'    => [
                    [
                        'class'  => 'yii\log\FileTarget',
                        'levels' => [ 'error', 'warning' ],
                    ],
                ],
            ],
            'errorHandler' => [
                'errorAction' => 'site/error',
            ],
            'urlManager'   => [
                'enablePrettyUrl'     => true,
                'enableStrictParsing' => false,
                'showScriptName'      => false,
                'rules'               => [
                    [
                        'class'      => 'yii\rest\UrlRule',
                        'controller' => [
                            'v1/categories' => 'v1/categories'
                        ]
                    ]
                ]
            ],
//            'response'     => [
//                'format'  => yii\web\Response::FORMAT_JSON,
//                'charset' => 'UTF-8',
//            ]
        ],
        'modules'             => [
            'v1' => [
                'class' => 'app\modules\v1\Module',
            ],
        ],
        'params'              => $params,
    ];
