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
            if ($rssSources = RssSources::findAll( array( "active" => "1", "is_full" => "0" ) )) {
                foreach ($rssSources as $source) {
//                    Yii::$app->getDb()->close();
//                    $pid = pcntl_fork();
//                    Yii::$app->getDb()->open();
//                    if ( ! $pid) {
                    $detector = new RssNewsDetectorComponent( $source );
                    $detector->run();
                    Yii::$app->end();
//                    }
                }

//                while (pcntl_waitpid( 0, $status ) != - 1) {
//                    $status = pcntl_wexitstatus( $status );
//                    echo "Child $status completed\n";
//                }
            }
        }
    }
