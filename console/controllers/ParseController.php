<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 24.10.14
     * Time: 15:04
     */
    namespace console\controllers;

    use common\components\PageLoaderComponent;
    use common\models\ParserQueue;
    use common\models\PendingNews;
    use yii\console\Controller;
    use common\components\RabbitMQComponent;

    use \ForceUTF8\Encoding;

    use Yii;
    use yii\db\Expression;

    class ParseController extends \yii\console\Controller {
        public function actionIndex() {
//        $this->stdout("Hello?\n", Console::BOLD);
            $mq = new RabbitMQComponent();
//            for ($i = 0; $i < 100; $i ++) {
            $mq->postMessage( "parse", "parse_rss", json_encode( [ "pn_id" => "311", "pq_id" => "1434" ] ) );
//                $mq->postMessage( "parse", "parse_rss", json_encode( [ "queue" => "parse", "route" => "parse_rss" ] ) );
//                $mq->postMessage( "compile", "compile", json_encode( [ "queue" => "compile", "route" => "compile" ] ) );
//                $mq->postMessage( "compile", "compile", json_encode( [ "queue" => "compile", "route" => "compile" ] ) );
//            }

//        Yii::$app->mq->postMessage("url", "parse", "http://nagg.in.ua");
            return 1;
        }

        public function actionConvert()
        {
            $url = 'http://fr.ill.in.ua/rss/ru/all.xml';
            echo PHP_EOL . "TRY LOAD {$url}" . PHP_EOL;
            $data = PageLoaderComponent::load( $url );

            preg_match( '/<\?xml.*?encoding=(\'|")(.*)("|\")/i', $data, $matches );
            print_r( $matches );
            if (isset( $matches[2] )) {
                $charset = $matches[2];
                $data    = mb_convert_encoding( $data, "UTF-8", $charset );
            } else {
                $data = mb_convert_encoding( $data, "UTF-8" );
            }

            print_r( $data );
        }

        public function actionCheck()
        {
            $pq             = new ParserQueue();
            $pq->source_id  = 1;
            $pq->url        = 'http://test.loc';
            $pq->status     = 'new';
            $pq->created_at = new Expression( "NOW()" );
            $pq->updated_at = new Expression( "NOW()" );
            if ($pq->insert()) {
                echo "\nSAVED with id {$pq->id}\n";
            } else {
                echo "\nFAILED\n";
                var_dump( $pq->getErrors() );
            }
        }
    }