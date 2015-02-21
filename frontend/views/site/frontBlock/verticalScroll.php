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
        <span class="meta"><?= Yii::$app->formatter->asDate( $news->created_at,
                "php:" . Yii::$app->params['newsDateFormat'] ); ?>
            <?php if ($categories = $news->getCategoryList()): ?>
                <?php foreach ($categories as $category): ?>
                    \\ <a href="<?= $category->getLink(); ?>"><?= $category->name; ?></a>
                <?php endforeach; ?>
            <?php endif; ?>
        </span>

        <p><?= $news->getShort(); ?></p>
    </div>

    <div class="outertight m-r-no">

        <ul class="block" id="carousel">
            <?php foreach ($data as $item): ?>
                <?= $this->render( 'news', [ "item" => $item ] ) ?>
            <?php endforeach; ?>
        </ul>
    </div>
</div>