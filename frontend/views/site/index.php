<?php
/* @var $this yii\web\View */
    $this->title = 'Свежие новости';
?>

<!-- Slider -->
<section id="slider">
    <div class="container">
        <?= $this->render( 'frontBlock/sliders', [ "data" => $sliders, "title" => "Самые цитируемые новости" ] ) ?>
    </div>
</section>
<!-- / Slider -->

<!-- Content -->
<section id="content">
<div class="container">
<!-- Main Content -->
<div class="main-content">

    <!-- Popular News -->
    <?= $this->render( 'frontBlock/4horizontal', [ "title" => "Популярные новости", "data" => $topNews ] ) ?>

    <!-- /Popular News -->

    <!-- Hot News -->
    <?= $this->render( 'frontBlock/4horizontal', [ "title" => "Посление новости", "data" => $hotNews ] ) ?>
    <!-- /Hot News -->

    <!-- Life Style -->
    <?= $this->render( 'frontBlock/verticalScroll', [ "title" => "Новости АТО", "data" => $atoNews ] ) ?>

    <!-- /Life Style -->

    <!-- World News -->
    <?= $this->render( 'frontBlock/horizontalScroll', [ "title" => "Экономические новости", "data" => $ecoNews ] ) ?>
    <!-- /World News -->

    <!-- Popular News -->
    <div class="column-two-third">
        <div class="outertight">
            <?= $this->render( 'frontBlock/3vertical', [ "title" => "Новости спорта", "data" => $sportNews ] ) ?>
        </div>

        <div class="outertight m-r-no">
            <?= $this->render( 'frontBlock/3vertical',
                [ "title" => "Политические новости", "data" => $politicsNews ] ) ?>
        </div>

    </div>
    <!-- /Popular News -->

</div>
<!-- /Main Content -->

<!-- Left Sidebar -->
    <?= $this->render( '../layouts/_parts/sidebar', [ ] ) ?>
<!-- /Left Sidebar -->

    </div>
</section>
<!-- / Content -->



