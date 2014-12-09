<div class="main-slider">
    <div class="badg">
        <p><a href="#">Popular.</a></p>
    </div>
    <div class="flexslider">
        <ul class="slides">
            <?php for ($i = 0; $i < 5; $i ++): ?>
                <?php $item = array_shift( $data ); ?>
                <li>
                    <img src="<?= $item->getThumbLink( "topNews" ) ?>"
                         alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"/>

                    <p class="flex-caption"><a
                            href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a> <?= \yii\helpers\Html::encode( $item->getShort() ); ?>
                    </p>
                </li>
            <?php endfor; ?>
        </ul>
    </div>
</div>
<div class="slider2">
    <?php $item = array_shift( $data ); ?>
    <div class="badg">
        <p><a href="#">Latest.</a></p>
    </div>
    <a href="<?= $item->getLink(); ?>"><img src="<?= $item->getThumbLink( "topNews" ) ?>"
                                            alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"/></a>

    <p class="caption"><a
            href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a> <?= \yii\helpers\Html::encode( $item->getShort( 100 ) ); ?>
    </p>
</div>

<div class="slider3">
    <?php $item = array_shift( $data ); ?>
    <a href="<?= $item->getLink(); ?>"><img src="<?= $item->getThumbLink( "sideNews" ) ?>"
                                            alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"/></a>

    <p class="caption"><a href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a></p>
</div>

<div class="slider3">
    <?php $item = array_shift( $data ); ?>
    <a href="<?= $item->getLink(); ?>"><img src="<?= $item->getThumbLink( "sideNews" ) ?>"
                                            alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"/></a>

    <p class="caption"><a href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a></p>
</div>