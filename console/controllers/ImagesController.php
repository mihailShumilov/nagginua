<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/7/14
     * Time: 23:45
     */

    namespace console\controllers;

    use common\components\PageLoaderComponent;
    use Yii;
    use common\components\RabbitMQComponent;
    use yii\console\Controller;

    class ImagesController extends Controller
    {

        public function actionIndex()
        {
            $mq = new RabbitMQComponent();
            $mq->consume( "image", "image", array( $this, 'processMessage' ) );
        }

        public static function processMessage( $msg )
        {
            $params = json_decode( $msg->body );
            print_r( $params );
            $dirPath = Yii::getAlias( '@frontend' ) . '/web/uploads/' . date( "Y" ) . '/' . date( "m" ) . "/" . date( "d" ) . "/" . $params->news_id . "/";
            if ( ! file_exists( $dirPath )) {
                mkdir( $dirPath, 0777, true );
            }
            $tmpFile    = PageLoaderComponent::loadFile( $params->src );
            $originFile = $dirPath . "origin";
            copy( $tmpFile, $originFile );
            unlink( $tmpFile );
            $image = \ImageEditor::createFromFile( $originFile );
            foreach (Yii::$app->params['image_sizes'] as $title => $size) {
                $image->zoomWidthTo( $size['width'] );
                $image->save( $dirPath . $title . ".jpg", "jpg", 80 );
            }


            $msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag'] );
        }

    }