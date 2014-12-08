<?php
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
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
