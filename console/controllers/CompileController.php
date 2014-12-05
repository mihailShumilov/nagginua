<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/4/14
     * Time: 23:46
     */

    namespace console\controllers;

    use yii\console\Controller;
    use common\components\RabbitMQComponent;

    class CompileController extends Controller
    {
        public function actionIndex()
        {
            $mq = new RabbitMQComponent();
            $mq->consume( "compile", "compile", array( $this, 'processMessage' ) );
        }

        public static function processMessage( $msg )
        {
//        print_r($msg);
            $params = json_decode( $msg->body );
            print_r( $params );
//        $msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag'] );
        }
    }