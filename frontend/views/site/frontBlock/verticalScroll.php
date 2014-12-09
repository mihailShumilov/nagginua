<div class="column-two-third">
    <h5 class="line">
        <span><?= \yii\helpers\Html::encode( $title ); ?></span>

        <div class="navbar">
            <a id="next1" class="next" href="#"><span></span></a>
            <a id="prev1" class="prev" href="#"><span></span></a>
        </div>
    </h5>

    <div class="outertight">
        <?php $news = array_shift( $data ); ?>
        <img src="<?= $news->getThumbLink( "thumbCategory" ) ?>"
             alt="<?= \yii\helpers\Html::encode( $news->title ); ?>"/>
        <h6 class="regular"><a href="<?= $news->getLink(); ?>"><?= \yii\helpers\Html::encode( $news->title ); ?></a>
        </h6>
        <span class="meta"><?= date( "d M, Y", strtotime( $news->created_at ) ); ?>  \\   <a href="#">World News.</a>   \\   <a
                href="#">No Coments.</a></span>

        <p><?= $news->getShort(); ?></p>
    </div>

    <div class="outertight m-r-no">

        <ul class="block" id="carousel">
            <?php foreach ($data as $item): ?>
                <li>
                    <a href="<?= $item->getLink(); ?>"><img src="<?= $item->getThumbLink( 'thumbNews' ); ?>"
                                                            alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"
                                                            class="alignleft"/></a>

                    <p>
                        <span><?= date( "d M, Y", strtotime( $item->created_at ) ); ?></span>
                        <a href="<?= $item->getLink(); ?>"><?= $item->title; ?></a>
                    </p>
                    <!--                <span class="rating"><span style="width:80%;"></span></span>-->
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>