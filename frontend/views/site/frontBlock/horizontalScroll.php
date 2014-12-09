<div class="column-two-third">
    <h5 class="line">
        <span><?= \yii\helpers\Html::encode( $title ); ?></span>

        <div class="navbar">
            <a id="next2" class="next" href="#"><span></span></a>
            <a id="prev2" class="prev" href="#"><span></span></a>
        </div>
    </h5>

    <div class="outerwide">
        <ul class="wnews" id="carousel2">
            <?php for ($i = 0; $i < 3; $i ++): ?>
                <?php $item = array_shift( $data ); ?>
                <li>
                    <img src="<?= $item->getThumbLink( "thumbCategory" ); ?>"
                         alt="<?= \yii\helpers\Html::encode( $item->title ); ?>" class="alignleft"/>
                    <h6 class="regular"><a
                            href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a></h6>
                <span class="meta"><?= date( "d M, Y", strtotime( $item->created_at ) ); ?>   \\   <a href="#">World
                        News.</a>   \\   <a href="#">No
                        Coments.</a></span>

                    <p><?= \yii\helpers\Html::encode( $item->getShort() ); ?></p>
                </li>
            <?php endfor; ?>

        </ul>
    </div>

    <div class="outerwide">
        <ul class="block2">
            <?php foreach ($data as $key => $item): ?>
                <li <?php if ($key % 2 == 0): ?>class="m-r-no"<?php endif; ?>>
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