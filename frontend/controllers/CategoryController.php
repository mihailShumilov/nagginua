<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/9/14
     * Time: 23:52
     */

    namespace frontend\controllers;

    use common\models\Categories;
    use common\models\News;
    use common\models\NewsHasCategory;
    use Yii;
    use yii\data\ActiveDataProvider;
    use yii\web\Controller;


    class CategoryController extends Controller
    {
        public function actionIndex( $slug )
        {

            $this->layout = 'category';

            $query = News::find();
            $category = Categories::findOne( [ 'slug' => $slug ] );
            if ( ! $category) {
                $this->redirect( "/" );
            }

            if ('all' != $slug) {
                $catArr   = [ ];
                $catArr[] = $category->id;
                if ($subcatList = $category->child) {
                    foreach ($subcatList as $subcat) {
                        $catArr[] = $subcat->id;
                    }
                }
                $query->join( 'INNER JOIN', NewsHasCategory::tableName(),
                    NewsHasCategory::tableName() . ".news_id = " . News::tableName() . ".id" );
                $query->where( [ NewsHasCategory::tableName() . '.category_id' => $catArr ] );
            }
            $query->orderBy( [ 'id' => SORT_DESC ] );

            $provider = new ActiveDataProvider( [
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 26,
                ],
            ] );
            $breadCrumbs = [ ];
            $breadCrumbs[] = [ 'label' => 'Главная', 'url' => '/' ];
            $breadCrumbs[] = [ 'label' => 'Категории', 'url' => '/category/all' ];
            $breadCrumbs[] = [ 'label' => ( isset( $category ) ? $category->name : "Все новости" ) ];

            Yii::$app->view->title = isset( $category ) ? $category->name : "Все новости";
            Yii::$app->view->registerMetaTag( [ 'name'    => 'keywords',
                                                'content' => ( isset( $category ) ? $category->name : "Все новости" ) . ' новости, свежие новости, новости украины, новости сегодня, агрегатор новостей'
            ] );
            Yii::$app->view->registerMetaTag( [ 'name'    => 'description',
                                                'content' => 'Свежие новости со всех Украинских сайтов в одном сайте. Агрегатор новостей'
            ], 'description' );
            Yii::$app->view->registerMetaTag( [ 'name' => 'og:title', 'content' => Yii::$app->view->title ],
                'og:title' );

            return $this->render( 'index', [
                'provider'    => $provider,
                'slug'        => $slug,
                'category'    => isset( $category ) ? $category->name : "Все новости",
                'breadcrumbs' => $breadCrumbs
            ] );
        }
    }