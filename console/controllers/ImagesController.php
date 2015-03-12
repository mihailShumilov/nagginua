<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/7/14
     * Time: 23:45
     */

    namespace console\controllers;

    use common\components\ImageEditor;
    use common\components\PageLoaderComponent;
    use common\models\News;
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
            $msg->delivery_info['channel']->basic_ack( $msg->delivery_info['delivery_tag'] );
            $params = json_decode( $msg->body );
            print_r( $params );
            try {
                $news    = News::findOne( [ 'id' => $params->news_id ] );
                $dirPath = Yii::getAlias( '@frontend' ) . '/web/uploads/' . date( "Y",
                        strtotime( $news->created_at ) ) . '/' . date( "m",
                        strtotime( $news->created_at ) ) . "/" . date( "d",
                        strtotime( $news->created_at ) ) . "/" . $params->news_id . "/";
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
                                $image = new ImageEditor();
                                $image->load( $originFile );
                                foreach (Yii::$app->params['image_sizes'] as $title => $size) {
                                    $image->softThumb( $size['width'], $size['height'], $dirPath . $title . ".png" );

                                }
                            } else {
                                throw new \Exception( "Origin file isn't an image", 400 );
                            }
                        } catch ( Exception $e ) {
                            echo "Error: {$e->getMessage()}" . PHP_EOL;
                        }
                        fclose( $handle );
                    } else {
                        throw new \Exception( "Can't open origin file", 400 );
                    }
                }
            } catch ( \Exception $e ) {
                echo $e->getMessage();
            }
        }

    }