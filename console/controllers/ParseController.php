<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 24.10.14
     * Time: 15:04
     */
    namespace console\controllers;

    use yii\console\Controller;
    use common\components\RabbitMQComponent;


    use Yii;

    class ParseController extends \yii\console\Controller {
        public function actionIndex() {
//        $this->stdout("Hello?\n", Console::BOLD);
            $mq = new RabbitMQComponent();
            $mq->postMessage( "url", "parse", "http://nagg.in.ua" );

//        Yii::$app->mq->postMessage("url", "parse", "http://nagg.in.ua");
            return 1;
        }
    }