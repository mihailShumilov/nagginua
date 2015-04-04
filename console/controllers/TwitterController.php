<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/12/14
     * Time: 22:27
     */

    namespace console\controllers;

    use Yii;
    use common\components\RabbitMQComponent;
    use yii\base\Exception;
    use yii\console\Controller;
    use common\models\News;
    use Codebird\Codebird;


    class TwitterController extends Controller
    {
        public function actionIndex()
        {
            $mq = new RabbitMQComponent();
            $mq->consume( "twitter", "twitter", array( $this, 'processMessage' ) );
        }

        public static function processMessage( $msg )
        {
            $params = json_decode( $msg->body );
            print_r( $params );
            try {
                $news = News::findOne( $params->news_id );
                $text = mb_substr( $news->title, 0,
                    ( 140 - strlen( Yii::$app->params['domainName'] . $news->getLink() ) ), 'utf-8' );
                $text .= " " . Yii::$app->params['domainName'] . $news->getLink();

                Codebird::setConsumerKey( Yii::$app->params['twitter']['consumer_key'],
                    Yii::$app->params['twitter']['consumer_secret'] );
                $cb = Codebird::getInstance();
                $cb->setToken( Yii::$app->params['twitter']['access_token'],
                    Yii::$app->params['twitter']['access_token_secret'] );
                $params = array(
                    'status'  => $text,
                    'media[]' => $params->src
                );
                $reply  = $cb->statuses_updateWithMedia( $params );

            } catch ( Exception $e ) {
                echo $e->getMessage();
            }

            $msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag'] );
        }
    }