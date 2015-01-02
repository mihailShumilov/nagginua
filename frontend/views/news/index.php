<?php
    $this->params['breadcrumbs'] = $breadcrumbs;
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
        <div id="disqus_thread"></div>
        <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'nagg'; // required: replace example with your forum shortname

            /* * * DON'T EDIT BELOW THIS LINE * * */
            (
                function ()
                {
                    var dsq = document.createElement( 'script' );
                    dsq.type = 'text/javascript';
                    dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (
                    document.getElementsByTagName( 'head' )[0] || document.getElementsByTagName( 'body' )[0]
                    ).appendChild( dsq );
                }
            )();
        </script>
        <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by
                Disqus.</a></noscript>

    </div>


</div>