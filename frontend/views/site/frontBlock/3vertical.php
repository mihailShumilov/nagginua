<h5 class="line"><span><?= \yii\helpers\Html::encode( $title ); ?></span></h5>

<div class="outertight m-r-no">
    <?php $item = array_shift( $data ); ?>
    <div class="flexslider">
        <ul class="slides">
            <li>
                <img src="<?= $item->getThumbLink( "thumbCategory" ); ?>"
                     alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"/>
            </li>
        </ul>
    </div>

    <h6 class="regular"><a href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a></h6>
            <span class="meta"><?= date( "d M, Y", strtotime( $item->created_at ) ); ?>.   \\   <a href="#">World
                    News.</a>   \\   <a href="#">No
                    Coments.</a></span>

    <p><?= \yii\helpers\Html::encode( $item->getShort() ); ?></p>
</div>

<ul class="block">
    <?php foreach ($data as $item): ?>
        <?= $this->render( 'news', [ "item" => $item ] ) ?>
    <?php endforeach; ?>
</ul>