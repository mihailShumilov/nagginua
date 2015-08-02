<?php
    $this->params['breadcrumbs'] = $breadcrumbs;
?>
<div itemscope itemtype="http://schema.org/Article" class="column-two-third single">
    <?php foreach ($news->pendingNews as $item): ?>
        <meta itemprop="articleBody" content="<?= \yii\helpers\Html::encode( $item->content ); ?>"/>
    <?php endforeach; ?>
    <div class="flexslider">
        <ul class="slides">
            <li>
                <img itemprop="image" src="<?= $news->getThumbLink( "topNews" ); ?>"
                     alt="<?= \yii\helpers\Html::encode( $news->title ); ?>"/>
            </li>
        </ul>
    </div>

    <h6 itemprop="name" class="title"><?= \yii\helpers\Html::encode( $news->title ); ?></h6>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- Под тайтлом новости -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-9725027434111611"
         data-ad-slot="2990349687"
         data-ad-format="auto"></ins>
    <script>
        (
            adsbygoogle = window.adsbygoogle || []
        ).push( {} );
    </script>
    <span class="meta"><span itemprop="datePublished" content="<?= Yii::$app->formatter->asDate( $news->created_at,
            "php:" . Yii::$app->params['newsDateFormat'] ); ?>"><?= Yii::$app->formatter->asDate( $news->created_at,
                "php:" . Yii::$app->params['newsDateFormat'] ); ?></span>
        . <?php if ($categories = $news->getCategoryList()): ?>
            <span itemprop="articleSection">
            <?php foreach ($categories as $category): ?>
                \\ <a href="<?= $category->getLink(); ?>"><?= $category->name; ?></a>
            <?php endforeach; ?>
            </span>
        <?php endif; ?></span>

    <div id="newsContent">
        <ul>
            <?php foreach ($news->pendingNews as $item): ?>
                <li><a href="#tabs-<?= $item->id; ?>"><?= $item->source->label; ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php foreach ($news->pendingNews as $item): ?>

            <div id="tabs-<?= $item->id; ?>">
                <p>Источник: <a href="<?= $item->source->url; ?>" target="_blank"><?= $item->source->label; ?></a></p>
                <?= \yii\helpers\HtmlPurifier::process( nl2br( $item->content ) ); ?>
            </div>
        <?php endforeach; ?>
    </div>
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