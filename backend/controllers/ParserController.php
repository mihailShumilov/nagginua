<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/22/14
     * Time: 05:41
     */

    namespace backend\controllers;

    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;

    class ParserController extends Controller
    {


        public function actionTest()
        {
            return $this->render( 'test' );
        }
    }