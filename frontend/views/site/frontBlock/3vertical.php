<h5 class="line"><span><?= \yii\helpers\Html::encode( $title ); ?></span></h5>

<div class="outertight m-r-no">
    <?php if ($item = array_shift( $data )): ?>
    <div class="flexslider">
        <ul class="slides">
            <li>
                <img src="<?= $item->getThumbLink( "thumbCategory" ); ?>"
                     alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"/>
            </li>
        </ul>
    </div>


    <h6 class="regular"><a href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a></h6>
            <span class="meta"><?= date( "d M, Y", strtotime( $item->created_at ) ); ?>.
                <?php if ($categories = $item->getCategoryList()): ?>
                    <?php foreach ($categories as $category): ?>
                        \\ <a href="<?= $category->getLink(); ?>"><?= $category->name; ?></a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </span>
    <p><?= \yii\helpers\Html::encode( $item->getShort() ); ?></p>
    <?php endif; ?>
</div>

<ul class="block">
    <?php foreach ($data as $item): ?>
        <?= $this->render( 'news', [ "item" => $item ] ) ?>
    <?php endforeach; ?>
</ul>