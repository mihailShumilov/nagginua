<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/9/14
     * Time: 23:52
     */

    namespace frontend\controllers;

    use Yii;
    use yii\web\Controller;


    class CategoryController extends Controller
    {
        public function actionIndex( $slug )
        {
            $this->layout = 'category';
            return $this->render( 'index', [ ] );
        }
    }