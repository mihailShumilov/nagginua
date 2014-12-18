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

            if ('all' != $slug) {
                $category = Categories::findOne( [ 'slug' => $slug ] );
                $query->join( 'INNER JOIN', NewsHasCategory::tableName(),
                    NewsHasCategory::tableName() . ".news_id = " . News::tableName() . ".id" );
                $query->where( [ NewsHasCategory::tableName() . '.category_id' => $category->id ] );
            }
            $query->orderBy( [ 'id' => SORT_DESC ] );

            $provider = new ActiveDataProvider( [
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 16,
                ],
            ] );
            return $this->render( 'index', [ 'provider' => $provider, 'slug' => $slug ] );
        }
    }