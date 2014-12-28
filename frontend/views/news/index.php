<?php
    $this->title = $news->title;
    $this->params['breadcrumbs'] = $breadcrumbs;
    $this->registerMetaTag( [ 'name' => 'description', 'content' => $news->getShort(), 'description' ] );

?>
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
        <div class="pendingNews" id="<?= $item->id; ?>" style="display: none;">
            <p>Источник: <a href="<?= $item->source->url; ?>" target="_blank"><?= $item->source->label; ?></a></p>
            <?= \yii\helpers\HtmlPurifier::process( $item->content ); ?>
        </div>
    <?php endforeach; ?>
    <ul class="sharebox">
        <?php foreach ($news->pendingNews as $item): ?>
            <li><a class="sourceSwitch" href="#<?= $item->id; ?>"><?= $item->source->label ?></a></li>
        <?php endforeach; ?>

    </ul>




    <div class="comments">

    </div>


</div>