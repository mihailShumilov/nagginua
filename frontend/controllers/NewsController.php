<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/9/14
     * Time: 23:52
     */

    namespace frontend\controllers;

    use common\models\News;
    use Yii;
    use yii\helpers\Html;
    use yii\web\Controller;



    class NewsController extends Controller
    {
        public function actionIndex( $id, $title )
        {
            $this->layout = 'category';

            $news = News::findOne( $id );
            if ( ! $news) {
                $this->redirect( "/" );
            }

            $breadCrumbs   = [ ];
            $breadCrumbs[] = [ 'label' => 'Главная', 'url' => '/' ];
            $breadCrumbs[] = [ 'label' => 'Все новости', 'url' => '/category/all' ];
            $breadCrumbs[] = [ 'label' => $news->title ];

            Yii::$app->view->title = $news->title;
            Yii::$app->view->registerMetaTag( [ 'name'    => 'keywords',
                                                'content' => 'новости, свежие новости, новости украины, новости сегодня, агрегатор новостей'
            ] );
            Yii::$app->view->registerMetaTag( [ 'name'    => 'description',
                                                'content' => Html::encode( $news->getShort() )
            ], 'description' );
            Yii::$app->view->registerMetaTag( [ 'name' => 'og:title', 'content' => Yii::$app->view->title ],
                'og:title' );
            Yii::$app->view->registerMetaTag( [ 'name' => 'og:image', 'content' => $news->getThumbLink() ],
                'og:image' );
            Yii::$app->view->registerMetaTag( [ 'name'    => 'og:description',
                                                'content' => Html::encode( $news->getShort() )
            ], 'og:description' );
            Yii::$app->view->registerMetaTag( [ 'name' => 'og:url', 'content' => $news->getLink() ], 'og:url' );



            return $this->render( 'index', [ 'news' => $news, 'breadcrumbs' => $breadCrumbs ] );
        }
    }