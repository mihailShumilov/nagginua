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
    use yii\base\Exception;
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
            try {
                $dirPath = Yii::getAlias( '@frontend' ) . '/web/uploads/' . date( "Y" ) . '/' . date( "m" ) . "/" . date( "d" ) . "/" . $params->news_id . "/";
                if ( ! file_exists( $dirPath )) {
                    mkdir( $dirPath, 0777, true );
                }
                if ($tmpFile = PageLoaderComponent::loadFile( $params->src )) {
                    $originFile = $dirPath . "origin";
                    copy( $tmpFile, $originFile );
                    unlink( $tmpFile );
                    echo "Origin file: {$originFile}" . PHP_EOL;
                    if ($handle = @fopen( $originFile, 'r' )) {
                        try {
                            if (file_exists( $originFile ) && ( $data = @getimagesize( $originFile ) )) {
                                foreach (Yii::$app->params['image_sizes'] as $title => $size) {
                                    $image = \ImageEditor::createFromFile( $originFile );
                                    $image->zoomWidthTo( $size['width'] );
                                    if ($image->getHeight() > $size['height']) {
                                        $marginTop    = ( $image->getHeight() - $size['height'] ) / 2;
                                        $marginBottom = $image->getHeight() - $marginTop;
                                        $image->crop( 0, $marginTop, $size['width'], $marginBottom );
                                        $image->zoomHeightTo( $size['height'] );
                                    }
                                    $image->save( $dirPath . $title . ".png", "png", 100 );
                                }
                            }
                        } catch ( Exception $e ) {
                            echo "Error: {$e->getMessage()}" . PHP_EOL;
                        }
                        fclose( $handle );
                    }
                }
            } catch ( Exception $e ) {
                echo $e->getMessage();
            }

            $msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag'] );
        }

    }