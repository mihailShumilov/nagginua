<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 24.10.14
     * Time: 15:04
     */
    namespace console\controllers;

    use common\components\PageLoaderComponent;
    use yii\console\Controller;
    use common\components\RabbitMQComponent;

    use \ForceUTF8\Encoding;

    use Yii;

    class ParseController extends \yii\console\Controller {
        public function actionIndex() {
//        $this->stdout("Hello?\n", Console::BOLD);
            $mq = new RabbitMQComponent();
            for ($i = 0; $i < 100; $i ++) {
                $mq->postMessage( "parse", "parse_rss", json_encode( [ "queue" => "parse", "route" => "parse_rss" ] ) );
                $mq->postMessage( "parse", "parse_rss", json_encode( [ "queue" => "parse", "route" => "parse_rss" ] ) );
                $mq->postMessage( "compile", "compile", json_encode( [ "queue" => "compile", "route" => "compile" ] ) );
                $mq->postMessage( "compile", "compile", json_encode( [ "queue" => "compile", "route" => "compile" ] ) );
            }

//        Yii::$app->mq->postMessage("url", "parse", "http://nagg.in.ua");
            return 1;
        }

        public function actionConvert()
        {
            $url  = 'http://forbes.ua/';
            $data = PageLoaderComponent::load( $url );
            preg_match( '/<meta.*?charset=(|\")(.*?)("|\")/i', $data, $matches );
            if (isset( $matches[2] )) {
                $charset = $matches[2];
                $data    = mb_convert_encoding( $data, "UTF-8", $charset );
            } else {
                $data = mb_convert_encoding( $data, "UTF-8" );
            }

            print_r( $data );
        }
    }