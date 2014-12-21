<div class="column-two-third single">
    <div class="flexslider">
        <ul class="slides">
            <li>
                <img src="<?= $news->getThumbLink( "topNews" ); ?>"
                     alt="<?= \yii\helpers\Html::encode( $news->title ); ?>"/>
            </li>
        </ul>
    </div>

    <h6 class="title"><?= \yii\helpers\Html::encode( $news->title ); ?></h6>
    <span class="meta"><?= date( "d M, Y", strtotime( $news->created_at ) ); ?>
        .   <?php if ($categories = $news->getCategoryList()): ?>
            <?php foreach ($categories as $category): ?>
                \\ <a href="<?= $category->getLink(); ?>"><?= $category->name; ?></a>
            <?php endforeach; ?>
                <?php endif; ?></span>
    <?php foreach ($news->pendingNews as $item): ?>
        <div class="pendingNews" id="<?= $item->id; ?>" style="display: none;"><?= $item->content; ?></div>
    <?php endforeach; ?>
    <ul class="sharebox">
        <?php foreach ($news->pendingNews as $item): ?>
            <li><a class="sourceSwitch" href="#<?= $item->id; ?>"><?= $item->source->label ?></a></li>
        <?php endforeach; ?>

    </ul>


    <!--    <div class="authorbox">-->
    <!--        <img src="img/trash/author.png" alt="MyPassion" />-->
    <!--        <h6>MyPassion.</h6>-->
    <!--        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In sodales dapibus dui, sed iaculis metus facilisis sed. Etiam scelerisque molestie purus vel mollis. Mauris dapibu quam id turpis dignissim rutrum.</p>-->
    <!--    </div>-->

    <!--    <div class="relatednews">-->
    <!--        <h5 class="line"><span>Related News.</span></h5>-->
    <!--        <ul>-->
    <!--            <li>-->
    <!--                <a href="#"><img src="img/trash/5.png" alt="MyPassion" /></a>-->
    <!--                <p>-->
    <!--                    <span>26 May, 2013.</span>-->
    <!--                    <a href="#">Blandit Rutrum, Erat et Sagittis.</a>-->
    <!--                </p>-->
    <!--                <span class="rating"><span style="width:80%;"></span></span>-->
    <!--            </li>-->
    <!--            <li>-->
    <!--                <a href="#"><img src="img/trash/6.png" alt="MyPassion" /></a>-->
    <!--                <p>-->
    <!--                    <span>26 May, 2013.</span>-->
    <!--                    <a href="#">Blandit Rutrum, Erat et Sagittis.</a>-->
    <!--                </p>-->
    <!--                <span class="rating"><span style="width:80%;"></span></span>-->
    <!--            </li>-->
    <!--            <li>-->
    <!--                <a href="#"><img src="img/trash/7.png" alt="MyPassion" /></a>-->
    <!--                <p>-->
    <!--                    <span>26 May, 2013.</span>-->
    <!--                    <a href="#">Blandit Rutrum, Erat et Sagittis.</a>-->
    <!--                </p>-->
    <!--                <span class="rating"><span style="width:80%;"></span></span>-->
    <!--            </li>-->
    <!--            <li>-->
    <!--                <a href="#"><img src="img/trash/8.png" alt="MyPassion" /></a>-->
    <!--                <p>-->
    <!--                    <span>26 May, 2013.</span>-->
    <!--                    <a href="#">Blandit Rutrum, Erat et Sagittis.</a>-->
    <!--                </p>-->
    <!--                <span class="rating"><span style="width:80%;"></span></span>-->
    <!--            </li>-->
    <!--        </ul>-->
    <!--    </div>-->

    <div class="comments">

    </div>


</div>