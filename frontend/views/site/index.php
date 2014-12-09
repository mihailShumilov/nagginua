<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>

<!-- Slider -->
<section id="slider">
    <div class="container">
        <?= $this->render( 'frontBlock/sliders', [ "data" => $sliders ] ) ?>
    </div>
</section>
<!-- / Slider -->

<!-- Content -->
<section id="content">
<div class="container">
<!-- Main Content -->
<div class="main-content">

    <!-- Popular News -->
    <?= $this->render( 'frontBlock/4horizontal', [ "title" => "Popular news", "data" => $topNews ] ) ?>

    <!-- /Popular News -->

    <!-- Hot News -->
    <?= $this->render( 'frontBlock/4horizontal', [ "title" => "Hot news", "data" => $hotNews ] ) ?>
    <!-- /Hot News -->

    <!-- Life Style -->
    <?= $this->render( 'frontBlock/verticalScroll', [ "title" => "Life style", "data" => $liveNews ] ) ?>

    <!-- /Life Style -->

    <!-- World News -->
    <?= $this->render( 'frontBlock/horizontalScroll', [ "title" => "World style", "data" => $worldNews ] ) ?>
    <!-- /World News -->

    <!-- Popular News -->
    <div class="column-two-third">
        <div class="outertight">
            <?= $this->render( 'frontBlock/3vertical', [ "title" => "Business news", "data" => $businessNews ] ) ?>
        </div>

        <div class="outertight m-r-no">
            <?= $this->render( 'frontBlock/3vertical', [ "title" => "Sport news", "data" => $sportNews ] ) ?>
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



