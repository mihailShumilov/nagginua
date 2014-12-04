<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 19.11.14
     * Time: 18:18
     */

    namespace console\controllers;

    use common\models\ParserQueue;
    use common\models\PendingNews;
    use yii\base\Exception;
    use yii\console\Controller;
    use common\components\RabbitMQComponent;
    use common\components\NewsParserComponent;


    class ProcessNewsController extends \yii\console\Controller
    {

        public function actionIndex()
        {
            $mq = new RabbitMQComponent();
            $mq->consume( "news", "parse_rss", array( $this, 'processMessage' ) );
        }

        public static function processMessage( $msg )
        {
            echo "\n--------\n";
            echo $msg->body;
            echo "\n--------\n";
            try {
                $params = json_decode( $msg->body );
                print_r( $params );
                $pqItem     = ParserQueue::findOne( [ "id" => $params->pq_id ] );
                $pnItem     = PendingNews::findOne( [ "id" => $params->pn_id ] );
                $newsParser = new NewsParserComponent( $pqItem, $pnItem );
                $newsParser->run();
            } catch ( Exception $e ) {
                echo $e->getMessage();
                $mq = new RabbitMQComponent();
                $mq->postMessage( "news", "parse_rss", $msg->body );
            }


            $msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag'] );
        }
    }