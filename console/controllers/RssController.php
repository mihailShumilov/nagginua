<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 26.11.14
     * Time: 06:21
     */

    namespace console\controllers;

    use Yii;
    use common\components\RabbitMQComponent;
    use common\models\RssSources;

    class RssController extends \yii\console\Controller
    {
        public function actionIndex()
        {
            $rssSources = RssSources::find( array( "status" => "active" ) )->all();
            foreach ($rssSources as $source) {

            }
        }
    }