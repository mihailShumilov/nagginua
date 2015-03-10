<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 3/7/15
     * Time: 08:41
     */

    namespace frontend\controllers;

    use yii\data\SqlDataProvider;
    use yii\web\Controller;


    class SearchController extends Controller
    {

        public function actionIndex( $q )
        {
            $this->layout   = 'category';
            $field          = 'search_content';
            $similar_weight = 0.1;

            $count = \Yii::$app->db->createCommand( "
    SELECT count(DISTINCT news.id)
                    from pending_news
                    inner join npn ON npn.pending_news_id = pending_news.id
                     inner join news on news.id = npn.news_id
                    where
		              to_tsvector('russian',pending_news.search_content) @@ plainto_tsquery('russian',:text)


", [ ':text' => $q ] )->queryScalar();


            $provider = new SqlDataProvider( [
                'sql' => "SELECT DISTINCT  news.id, news.title,
sum(ts_rank_cd(to_tsvector('russian',pending_news.search_content), plainto_tsquery('russian',:text)))/count(news.id) AS rank,
news.created_at, news.cnt
                    from pending_news
                    inner join npn ON npn.pending_news_id = pending_news.id
                     inner join news on news.id = npn.news_id
                    where
                    	to_tsvector('russian',pending_news.search_content) @@ plainto_tsquery('russian',:text)
                    and search_content <> '&nbsp;'
                    GROUP BY news.id
                    ",
                'params'     => [ ':text' => $q ],
                'totalCount' => $count,
                'sort'       => [
                    'attributes'   => [
                        'rank'       => [
                            'asc'     => [ 'rank' => SORT_ASC ],
                            'desc'    => [ 'rank' => SORT_DESC ],
                            'default' => SORT_DESC,
                            'label'   => 'Релевантность',
                        ],
                        'created_at' => [
                            'asc'     => [ 'created_at' => SORT_ASC ],
                            'desc'    => [ 'created_at' => SORT_DESC ],
                            'default' => SORT_DESC,
                            'label'   => 'Дата',
                        ],
                        'cnt'        => [
                            'asc'     => [ 'cnt' => SORT_ASC ],
                            'desc'    => [ 'cnt' => SORT_DESC ],
                            'default' => SORT_DESC,
                            'label'   => 'Популярность',
                        ],
                    ],
                    'defaultOrder' => [
                        'rank'       => SORT_DESC,
                        'created_at' => SORT_DESC,
                        'cnt'        => SORT_DESC,
                    ],
                ],
                'pagination' => [
                    'pageSize' => 16,
                ],
            ] );

            $breadCrumbs   = [ ];
            $breadCrumbs[] = [ 'label' => 'Главная', 'url' => '/' ];
            $breadCrumbs[] = [ 'label' => 'Поиск' ];
            $breadCrumbs[] = [ 'label' => $q ];

            return $this->render( 'index', [
                'provider'    => $provider,
                'slug'        => "Search",
                'category'    => "Search",
                'breadcrumbs' => $breadCrumbs,
                'query'       => $q
            ] );
        }
    }