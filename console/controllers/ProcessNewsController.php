<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 19.11.14
     * Time: 18:18
     */

    namespace console\controllers;

    use yii\console\Controller;
    use common\components\RabbitMQComponent;

    class ProcessNewsController extends \yii\console\Controller {

        public function actionIndex() {
            $mq = new RabbitMQComponent();
            $mq->consume( "url", "parse", array( $this, 'processMessage' ) );
        }

        public static function processMessage( $msg ) {
            echo "\n--------\n";
            echo $msg->body;
            echo "\n--------\n";

            $msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag'] );
        }
    }