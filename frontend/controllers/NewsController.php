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
    use yii\web\Controller;


    class NewsController extends Controller
    {
        public function actionIndex( $id )
        {
            $this->layout = 'category';

            $news = News::findOne( $id );

            return $this->render( 'index', [ 'news' => $news ] );
        }
    }