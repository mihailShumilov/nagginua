<?php
$params = array_merge(
    require( __DIR__ . '/../../common/config/params.php' ),
    require( __DIR__ . '/../../common/config/params-local.php' ),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl'     => true,
            'enableStrictParsing' => false,
            'showScriptName'      => false,
            'rules'               => [
                'category/<slug:\w+>' => 'category/index',
                'news/<id:\d+>/<title:[^/]*>' => 'news/index',
                [ 'pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml' ],
                'defaultRoute'  => 'site/index'
            ]
        ],
        'cache'      => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'modules'    => [
        'sitemap' => [
            'class'       => 'himiklab\sitemap\Sitemap',
            'models'      => [
                // your models
                'common\models\News',
                // or configuration for creating a behavior
                [
                    'class'     => 'common\models\News',
                    'behaviors' => [
                        'sitemap' => [
                            'class'       => \himiklab\sitemap\behaviors\SitemapBehavior::className(),
                            'scope'       => function ( $model ) {
                                /** @var \yii\db\ActiveQuery $model */
                                $model->andWhere( [ 'status' => 'done' ] );

                            },
                            'dataClosure' => function ( $model ) {
                                /** @var self $model */
                                return [
                                    'loc'        => $model->getLink(),
                                    'lastmod'    => strtotime( $model->updated_at ),
                                    'changefreq' => \himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                                    'priority'   => 0.8
                                ];
                            }
                        ],
                    ],
                ],
            ],
            'urls'        => [
                // your additional urls
                [
                    'loc'        => '/',
                    'changefreq' => \himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                    'priority'   => 0.8,
                    'news'       => [
                        'publication'      => [
                            'name'     => 'Агрегатор новостей',
                            'language' => 'ru',
                        ],
                        'access'           => 'Subscription',
                        'genres'           => 'новости',
                        'publication_date' => 'YYYY-MM-DDThh:mm:ssTZD',
                        'title'            => 'Агрегатор новостей',
                        'keywords'         => 'новости, свежие новости, новости украины, новости сегодня, агрегатор новостей',
                        'stock_tickers'    => 'NASDAQ:A, NASDAQ:B',
                    ],
                    'images'     => [
                        [
                            'loc'          => 'http://nagg.in.ua/',
                            'caption'      => 'Агрегатор новостей',
                            'geo_location' => 'Украина',
                            'title'        => 'Агрегатор новостей Украина',
                        ],
                    ],
                ],
            ],
            'enableGzip'  => true, // default is false
            'cacheExpire' => 1, // 1 second. Default is 24 hours
        ],
    ],
    'params' => $params,
];
