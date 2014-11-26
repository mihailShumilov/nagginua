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
    use common\components\RssNewsDetectorComponent;

    class RssController extends \yii\console\Controller
    {
        public function actionIndex()
        {
            $rssSources = RssSources::find( array( "status" => "active", "is_full" => "0" ) )->all();
            foreach ($rssSources as $source) {
                $detector = new RssNewsDetectorComponent( $source );
                $detector->run();
            }
        }
    }