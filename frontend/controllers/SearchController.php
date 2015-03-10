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
    SELECT count(news.id)
                    from pending_news
                    inner join npn ON npn.pending_news_id = pending_news.id
                     inner join news on news.id = npn.news_id
                    where
		              to_tsvector('russian',pending_news.search_content) @@ plainto_tsquery('russian',:text)


", [ ':text' => $q ] )->queryScalar();


            $provider = new SqlDataProvider( [
                'sql'        => "SELECT news.id, news.title,
ts_rank_cd(to_tsvector('russian',pending_news.search_content), plainto_tsquery('russian',:text)) AS rank,
news.created_at, news.cnt
                    from pending_news
                    inner join npn ON npn.pending_news_id = pending_news.id
                     inner join news on news.id = npn.news_id
                    where
                    	to_tsvector('russian',pending_news.search_content) @@ plainto_tsquery('russian',:text)
                    and search_content <> '&nbsp;'",
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

            return $this->render( 'index', [
                'provider'    => $provider,
                'slug'        => "Search",
                'category'    => "Search",
                'breadcrumbs' => [ ]
            ] );
        }
    }