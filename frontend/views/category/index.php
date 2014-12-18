<?php $news = $provider->getModels(); ?>
<div class="column-two-third">
<div class="outertight m-t-no">
    <?php $item = array_shift( $news ); ?>
    <div class="badg">
        <p><a href="#">Featured.</a></p>
    </div>
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

    <h6 class="regular"><a href="single.html">Blandit Rutrum, Erat et Sagittis. Lorem
            Ipsum Dolor, Sit Amet Adipsing.</a></h6>
    <span class="meta">26 May, 2013.   \\   <a href="#">World News.</a>   \\   <a href="#">No Coments.</a></span>

    <p>Blandit rutrum, erat et egestas ultricies, dolor tortor egestas enim, quiste rhoncus sem purus eu sapien.
        Curabitur a orci nec risus lacinia vehic. Lorem ipsum
        dolor adipcising elit. Erat egestan sagittis lorem aupo dolor sit ameta, auctor libero tempor...</p>
</div>

<div class="outertight m-r-no m-t-no">
    <?php $item = array_shift( $news ); ?>
    <div class="badg">
        <p><a href="#">Featured.</a></p>
    </div>
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

    <h6 class="regular"><a href="single.html">Blandit Rutrum, Erat et Sagittis. Lorem
            Ipsum Dolor, Sit Amet Adipsing.</a></h6>
    <span class="meta">26 May, 2013.   \\   <a href="#">World News.</a>   \\   <a href="#">No Coments.</a></span>

    <p>Blandit rutrum, erat et egestas ultricies, dolor tortor egestas enim, quiste rhoncus sem purus eu sapien.
        Curabitur a orci nec risus lacinia vehic. Lorem ipsum
        dolor adipcising elit. Erat egestan sagittis lorem aupo dolor sit ameta, auctor libero tempor...</p>
</div>

<div class="outerwide">
    <ul class="block2">
        <?php foreach ($news as $key => $item): ?>
            <?php $class = ( $key % 2 == 0 ) ? "" : "m-r-no"; ?>
            <?= $this->render( '../site/frontBlock/news', [ "item" => $item, "class" => $class ] ) ?>
        <?php endforeach; ?>
    </ul>
</div>

<div class="pager">
    <pre>
    <?php print_r( $provider->getPagination() ); ?>
        </pre>
    <?php $pager = $provider->getPagination(); ?>
    <ul>
        <?php for ($i = $pager->pageSizeLimit[0]; $i <= $pager->pageSizeLimit[1]; $i ++): ?>
            <?php if ($i == $pager->pageSizeLimit[0]): ?>
                <li><a href="<?= \yii\helpers\Url::toRoute( 'category/index',
                        [ 'slug' => $slug, $pager->pageParam => $i ] ) ?>" class="first-page"></a></li>
            <?php endif; ?>
            <li><a href="<?= \yii\helpers\Url::toRoute( 'category/index',
                    [ 'slug' => $slug, $pager->pageParam => $i ] ) ?>"
                   <?php if ($i == $pager->forcePageParam): ?>class="active"<?php endif; ?>><?= $i; ?></a></li>
            <?php if ($i == $pager->pageSizeLimit[1]): ?>
                <li><a href="<?= \yii\helpers\Url::toRoute( 'category/index',
                        [ 'slug' => $slug, $pager->pageParam => $i ] ) ?>" class="last-page"></a></li>
            <?php endif; ?>
        <?php endfor; ?>
    </ul>
</div>

</div>