<?php $news = $provider->getModels(); ?>
<div class="column-two-third">
    <div class="outertight m-t-no">
        <?php $item = array_shift( $news ); ?>
        <div class="badg">
            <p><a href="<?= $item->getLink(); ?>">Свежая.</a></p>
        </div>
        <div class="flexslider">
            <ul class="slides">
                <li>
                    <img src="<?= $item->getThumbLink( 'thumbCategory' ); ?>"
                         alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"/>
                </li>
            </ul>
        </div>

        <h6 class="regular"><a href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a>
        </h6>
        <span class="meta"><?= date( "d M, Y", strtotime( $item->created_at ) ); ?>
            <?php if ($categories = $item->getCategoryList()): ?>
                <?php foreach ($categories as $category): ?>
                    \\ <a href="<?= $category->getLink(); ?>"><?= $category->name; ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </span>

        <p><?= \yii\helpers\Html::encode( $item->getShort() ); ?></p>
    </div>

    <div class="outertight m-r-no m-t-no">
        <?php $item = array_shift( $news ); ?>
        <div class="badg">
            <p><a href="<?= $item->getLink(); ?>">Свежая.</a></p>
        </div>
        <div class="flexslider">
            <ul class="slides">
                <li>
                    <img src="<?= $item->getThumbLink( 'thumbCategory' ); ?>"
                         alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"/>
                </li>
            </ul>
        </div>

        <h6 class="regular"><a href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a>
        </h6>
        <span class="meta"><?= date( "d M, Y", strtotime( $item->created_at ) ); ?>
            <?php if ($categories = $item->getCategoryList()): ?>
                <?php foreach ($categories as $category): ?>
                    \\ <a href="<?= $category->getLink(); ?>"><?= $category->name; ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </span>

        <p><?= \yii\helpers\Html::encode( $item->getShort() ); ?></p>
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
        <?php $pager = $provider->getPagination(); ?>
        <?php echo \common\components\MLinkPager::widget( [
            'pagination'       => $provider->getPagination(),
            'options'          => [
                'class' => false
            ],
            'prevPageCssClass' => 'first-page',
            'nextPageCssClass' => 'last-page',
            'prevPageLabel'    => '&nbsp;',
            'nextPageLabel'    => '&nbsp;'
        ] );
        ?>
    </div>

</div>