<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 3/22/15
     * Time: 22:32
     */

    namespace app\modules\v1\controllers;


    use yii\rest\ActiveController;
    use yii\rest\Controller;
    use common\models\Categories;

    class NewsController extends ActiveController
    {
        public $modelClass = 'common\models\News';
    }