<div class="column-one-third">
    <div class="sidebar">
        <h5 class="line"><span>Будьте всегда на связи.</span></h5>
        <ul class="social">
            <li>
                <a href="https://www.facebook.com/profile.php?id=100008352076957&fref=ts&ref=br_tf" class="facebook"><i
                        class="icon-facebook"></i></a>
                <span>1 <br/> <i>фан</i></span>
            </li>
            <li>
                <a href="https://twitter.com/intent/follow?original_referer=<?php echo urlencode( $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] ) . "&region=follow_link&screen_name=nagginua&tw_p=followbutton&variant=2.0"; ?>"
                   class="twitter"><i class="icon-twitter"></i></a>
                <span>12 <br/> <i>читателей</i></span>
            </li>
            <li>
                <a href="#" class="rss"><i class="icon-rss"></i></a>
                <span><i>Подписаться на rss</i></span>
            </li>
        </ul>
    </div>

    <div class="sidebar">
        <div id="tabs">
            <ul>
                <li><a href="#tabs1">Последние.</a></li>
                <li><a href="#tabs2">Популярные.</a></li>
            </ul>
            <div id="tabs1">
                <ul>
                    <?php if ($news = \common\models\News::getLatestNews()): ?>
                        <?php foreach ($news as $item): ?>
                            <?= $this->render( 'sidebarNews', [ "item" => $item ] ) ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
            <div id="tabs2">
                <ul>
                    <?php if ($news = \common\models\News::getPopularNews()): ?>
                        <?php foreach ($news as $item): ?>
                            <?= $this->render( 'sidebarNews', [ "item" => $item ] ) ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="sidebar">
        <div id="minfincomua_i_usd">Загружаем межбанк от <a href="http://minfin.com.ua/">minfin.com.ua</a></div>
        <script type="text/javascript" src="http://informer.minfin.com.ua/interbank/usd.js"></script>
    </div>
    <div class="sidebar">
        <h5 class="line"><span>Реламма</span></h5>

        <div>
            <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
            <!-- Сайдбар -->
            <ins class="adsbygoogle"
                 style="display:block"
                 data-ad-client="ca-pub-9725027434111611"
                 data-ad-slot="7147374081"
                 data-ad-format="auto"></ins>
            <script>
                (
                    adsbygoogle = window.adsbygoogle || []
                ).push( {} );
            </script>
        </div>
    </div>
    <div class="sidebar">
        <div id="minfincomua_i_eur">Загружаем межбанк от <a href="http://minfin.com.ua/">minfin.com.ua</a></div>
        <script type="text/javascript" src="http://informer.minfin.com.ua/interbank/eur.js"></script>
    </div>
    <div class="sidebar">
        <div id="minfincomua_i_rub">Загружаем межбанк от <a href="http://minfin.com.ua/">minfin.com.ua</a></div>
        <script type="text/javascript" src="http://informer.minfin.com.ua/interbank/rub.js"></script>
    </div>
</div>