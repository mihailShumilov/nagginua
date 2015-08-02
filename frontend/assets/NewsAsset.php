<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 8/2/15
     * Time: 11:54
     */

    namespace frontend\assets;


    use yii\web\AssetBundle;

    class NewsAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $jsOptions = [ 'position' => \yii\web\View::POS_END ];
        public $css = [

            '/css/fontello/fontello.css',
            '/css/ui.css',
            '/css/base.css',
            '/css/style.css',
            '/css/960.css'
        ];
        public $js = [
            '/js/jquery.js',
            '/js/easing.min.js',
            '/js/1.8.2.min.js',
            '/js/ui.js',
            '/js/carouFredSel.js',
            '/js/superfish.js',
            '/js/customM.js',
            '/js/flexslider-min.js',
            '/js/tweetable.js',
            '/js/timeago.js',
            '/js/jflickrfeed.min.js',
            '/js/mobilemenu.js',
            '/js/mypassion.js',
            '/js/news.js'
        ];
        public $depends = [
            'yii\web\YiiAsset',
            'yii\bootstrap\BootstrapAsset',
        ];
    }