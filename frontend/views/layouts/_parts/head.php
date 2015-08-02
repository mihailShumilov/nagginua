<?php
    use yii\web\View;
    use yii\helpers\Html;
    use yii\bootstrap\Nav;
    use yii\bootstrap\NavBar;
    use yii\widgets\Breadcrumbs;
    use frontend\assets\AppAsset;
    use frontend\assets\NewsAsset;
    use frontend\widgets\Alert;

    NewsAsset::register( $this );
    AppAsset::register( $this );


?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <!--[if lt IE 7 ]>
    <html class="ie ie6" lang="ru"> <![endif]-->
    <!--[if IE 7 ]>
    <html class="ie ie7" lang="ru"> <![endif]-->
    <!--[if IE 8 ]>
    <html class="ie ie8" lang="ru"> <![endif]-->
    <!--[if (gte IE 9)|!(IE)]><!-->
    <html lang="ru"> <!--<![endif]-->

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="author" content="Mihail Shumilov">

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode( $this->title ) ?> - Агрегатор новостей</title>

        <?php $this->head() ?>
        <?php
            //Yii hack
            if ( ! empty( $this->metaTags )) {
                $lines[] = implode( "\n", $this->metaTags );
            }

            if ( ! empty( $this->linkTags )) {
                $lines[] = implode( "\n", $this->linkTags );
            }
            if ( ! empty( $this->cssFiles )) {
                $lines[] = implode( "\n", $this->cssFiles );
            }
            if ( ! empty( $this->css )) {
                $lines[] = implode( "\n", $this->css );
            }
            if ( ! empty( $this->jsFiles[\yii\web\View::POS_HEAD] )) {
                $lines[] = implode( "\n", $this->jsFiles[\yii\web\View::POS_HEAD] );
            }
            if ( ! empty( $this->js[\yii\web\View::POS_HEAD] )) {
                $lines[] = Html::script( implode( "\n", $this->js[\yii\web\View::POS_HEAD] ),
                    [ 'type' => 'text/javascript' ] );
            }
            echo empty( $lines ) ? '' : implode( "\n", $lines );
        ?>


        <link rel="shortcut icon" href="/img/sms-4.ico"/>

        <!-- STYLES -->
        <link rel="stylesheet" type="text/css" href="/css/superfish.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="/css/fontello/fontello.css"/>
        <link rel="stylesheet" type="text/css" href="/css/flexslider.css" media="screen"/>
        <link rel="stylesheet" type="text/css" href="/css/ui.css"/>
        <link rel="stylesheet" type="text/css" href="/css/base.css"/>
        <link rel="stylesheet" type="text/css" href="/css/style.css"/>
        <link rel="stylesheet" type="text/css" href="/css/960.css"/>
        <link rel="stylesheet" type="text/css" href="/css/devices/1000.css"
              media="only screen and (min-width: 768px) and (max-width: 1000px)"/>
        <link rel="stylesheet" type="text/css" href="/css/devices/767.css"
              media="only screen and (min-width: 480px) and (max-width: 767px)"/>
        <link rel="stylesheet" type="text/css" href="/css/devices/479.css"
              media="only screen and (min-width: 200px) and (max-width: 479px)"/>
        <link href='http://fonts.googleapis.com/css?family=Merriweather+Sans:400,300,700,800' rel='stylesheet'
              type='text/css'>
        <!--[if lt IE 9]>
        <script type="text/javascript" src="/js/customM.js"></script> <![endif]-->


    </head>
    <body>
<?php $this->beginBody() ?>