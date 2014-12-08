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
        <h5 class="line"><span>Business News.</span></h5>

        <div class="outertight m-r-no">
            <div class="flexslider">
                <ul class="slides">
                    <li>
                        <img src="img/trash/25.png" alt="MyPassion"/>
                    </li>
                    <li>
                        <img src="img/trash/24.png" alt="MyPassion"/>
                    </li>
                    <li>
                        <img src="img/trash/26.png" alt="MyPassion"/>
                    </li>
                </ul>
            </div>

            <h6 class="regular"><a href="#">Blandit Rutrum, Erat et Sagittis. Lorem
                    Ipsum Dolor, Sit Amet Adipsing.</a></h6>
            <span class="meta">26 May, 2013.   \\   <a href="#">World News.</a>   \\   <a href="#">No
                    Coments.</a></span>

            <p>Blandit rutrum, erat et egestas ultricies, dolor tortor egestas enim, quiste rhoncus sem purus eu sapien.
                Curabitur a orci nec risus lacinia vehic. Lorem ipsum
                dolor adipcising elit. Erat egestan sagittis lorem aupo dolor sit ameta, auctor libero tempor...</p>
        </div>

        <ul class="block">
            <li>
                <a href="#"><img src="img/trash/21.png" alt="MyPassion" class="alignleft"/></a>

                <p>
                    <span>26 May, 2013.</span>
                    <a href="#">Blandit Rutrum, Erat et Sagittis.</a>
                </p>
                <span class="rating"><span style="width:80%;"></span></span>
            </li>
            <li>
                <a href="#"><img src="img/trash/20.png" alt="MyPassion" class="alignleft"/></a>

                <p>
                    <span>26 May, 2013.</span>
                    <a href="#">Blandit Rutrum, Erat et Sagittis.</a>
                </p>
                <span class="rating"><span style="width:100%;"></span></span>
            </li>
        </ul>
    </div>

    <div class="outertight m-r-no">
        <h5 class="line"><span>Sport News.</span></h5>

        <div class="outertight m-r-no">
            <div class="flexslider">
                <ul class="slides">
                    <li>
                        <img src="img/trash/27.png" alt="MyPassion"/>
                    </li>
                    <li>
                        <img src="img/trash/26.png" alt="MyPassion"/>
                    </li>
                    <li>
                        <img src="img/trash/24.png" alt="MyPassion"/>
                    </li>
                </ul>
            </div>

            <h6 class="regular"><a href="#">Blandit Rutrum, Erat et Sagittis. Lorem
                    Ipsum Dolor, Sit Amet Adipsing.</a></h6>
            <span class="meta">26 May, 2013.   \\   <a href="#">World News.</a>   \\   <a href="#">No
                    Coments.</a></span>

            <p>Blandit rutrum, erat et egestas ultricies, dolor tortor egestas enim, quiste rhoncus sem purus eu sapien.
                Curabitur a orci nec risus lacinia vehic. Lorem ipsum
                dolor adipcising elit. Erat egestan sagittis lorem aupo dolor sit ameta, auctor libero tempor...</p>
        </div>

        <ul class="block">
            <li>
                <a href="#"><img src="img/trash/23.png" alt="MyPassion" class="alignleft"/></a>

                <p>
                    <span>26 May, 2013.</span>
                    <a href="#">Blandit Rutrum, Erat et Sagittis.</a>
                </p>
                <span class="rating"><span style="width:80%;"></span></span>
            </li>
            <li>
                <a href="#"><img src="img/trash/22.png" alt="MyPassion" class="alignleft"/></a>

                <p>
                    <span>26 May, 2013.</span>
                    <a href="#">Blandit Rutrum, Erat et Sagittis.</a>
                </p>
                <span class="rating"><span style="width:100%;"></span></span>
            </li>
        </ul>
    </div>

</div>
<!-- /Popular News -->

</div>
