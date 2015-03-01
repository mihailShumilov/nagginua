<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 2/22/15
     * Time: 22:34
     */

    namespace common\components;


    use yii\base\Component;

    class ImageEditor extends Component
    {

        /**
         * @var Imagick
         */
        private $originImage;
        private $originGeo;

        public function load( $path )
        {
            if (file_exists( $path )) {
                $this->originImage = new \Imagick( $path );
                $this->originGeo   = $this->originImage->getImageGeometry();
                print_r( $this->originGeo );
            } else {
                throw new \Exception( "File {$path} doesn't exists", 404 );
            }
        }

        public function softThumb( $width, $height, $path, $bg = 'transparent' )
        {
            if ($this->originImage) {
                echo "\nWrite image to `{$path}`\n";
                $resizeParams = $this->getSizes( $width, $height );
                $overlay      = clone $this->originImage;
                $overlay->scaleImage( $resizeParams['width'], $resizeParams['height'] );
                $overlayGeo = $overlay->getImageGeometry();
                if ($overlayGeo['width'] > $overlayGeo['height']) {
                    $resizeParams['top']  = ( $height - $overlayGeo['height'] ) / 2;
                    $resizeParams['left'] = 0;
                } else {
                    $resizeParams['top']  = 0;
                    $resizeParams['left'] = ( $width - $overlayGeo['width'] ) / 2;
                }
                $thumb = new \Imagick();
                $thumb->newImage( $width, $height, $bg );
                $thumb->setImageFormat( "png" );
                $thumb->setCompression( \Imagick::COMPRESSION_ZIP );
                $thumb->setImageCompressionQuality( 0 );
                $thumb->compositeImage( $overlay, \Imagick::COMPOSITE_DEFAULT, $resizeParams['left'],
                    $resizeParams['top'] );
                $thumb->writeImageFile( fopen( $path, "wb" ) );
                $thumb->destroy();
            } else {
                throw new \Exception( "As first You must load image", 404 );
            }
        }

        private function getSizes( $width, $height )
        {
            $result = [ ];
            if ($this->originGeo['width'] >= $this->originGeo['height']) {
                $result['width']  = $width;
                $result['height'] = 0;
            } else {
                $proportion       = $this->originGeo['width'] / $this->originGeo['height'];
                $result['width']  = 0;
                $result['height'] = $height;
                $result['left']   = (int) ( ( $width - ( $width * $proportion ) ) / 2 );
                $result['top']    = 0;
            }
            return $result;
        }
    }