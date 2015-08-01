<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 6/25/15
     * Time: 06:24
     */

    namespace frontend\assets;


    use yii\web\AssetBundle;

    class ThemeAsset extends AssetBundle
    {
        public $basePath = '@webroot';
        public $baseUrl = '@web';
        public $css = [
            'css/fontello/fontello.css',
            'css/ui.css',
            'css/base.css',
            'css/style.css',
            'css/960.css',
            'http://fonts.googleapis.com/css?family=Merriweather+Sans:400,300,700,800'
        ];
    }