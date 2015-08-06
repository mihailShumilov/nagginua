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
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- сайдбар статика -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:600px"
     data-ad-client="ca-pub-9725027434111611"
     data-ad-slot="4827420085"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
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
    <!-- div class="sidebar">
        <h5 class="line"><span>Реклама.</span></h5>

</div -->
    <div class="sidebar">
        <div id="minfincomua_i_eur">Загружаем межбанк от <a href="http://minfin.com.ua/">minfin.com.ua</a></div>
        <script type="text/javascript" src="http://informer.minfin.com.ua/interbank/eur.js"></script>
    </div>
    <div class="sidebar">
        <div id="minfincomua_i_rub">Загружаем межбанк от <a href="http://minfin.com.ua/">minfin.com.ua</a></div>
        <script type="text/javascript" src="http://informer.minfin.com.ua/interbank/rub.js"></script>
    </div>
    <div class="sidebar">
        <h5 class="line"><span>Поддержать проект.</span></h5>

        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
            <input type="hidden" name="cmd" value="_s-xclick">
            <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
            <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0"
                   name="submit" alt="PayPal - The safer, easier way to pay online!">
            <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
        </form>

    </div>
    <div class="sidebar">
        <!--LiveInternet counter-->
        <script type="text/javascript"><!--
            document.write( "<a href='//www.liveinternet.ru/click' " +
                            "target=_blank><img src='//counter.yadro.ru/hit?t14.6;r" +
                            escape( document.referrer ) + (
                                (
                                typeof(
                                    screen
                                ) == "undefined"
                                ) ? "" :
                                ";s" + screen.width + "*" + screen.height + "*" + (
                                    screen.colorDepth ?
                                        screen.colorDepth : screen.pixelDepth
                                )
                            ) + ";u" + escape( document.URL ) +
                            ";" + Math.random() +
                            "' alt='' title='LiveInternet: показано число просмотров за 24" +
                            " часа, посетителей за 24 часа и за сегодня' " +
                            "border='0' width='88' height='31'><\/a>" )
            //--></script>
        <!--/LiveInternet-->
        <!--bigmir)net TOP 100-->
        <script type="text/javascript" language="javascript"><!--
            function BM_Draw(oBM_STAT){
                document.write('<table cellpadding="0" cellspacing="0" border="0" style="display:inline;margin-right:4px;"><tr><td><div style="margin:0;padding:0;font-size:1px;width:88px;"><div style="background:url(\'//i.bigmir.net/cnt/samples/diagonal/b59_top.gif\') no-repeat top;height:1px;line-height:1px;"> </div><div style="font:10px Tahoma;text-align:center;background-color:#EFEFEF;height:15px;"><a href="http://www.bigmir.net/" target="_blank" style="color:#0000ab;text-decoration:none;">bigmir<span style="color:#ff0000;">)</span>net</a></div><div style="height:1px;background:url(\'//i.bigmir.net/cnt/samples/diagonal/b59_top.gif\') no-repeat bottom;"></div><div style="font:10px Tahoma;padding-left:7px;background:url(\'//i.bigmir.net/cnt/samples/diagonal/b59_center.gif\');"><div style="padding:4px 6px 0 0;"><div style="float:left;color:#969696;">хиты</div><div style="float:right;color:#003596;font:10px Tahoma;">'+oBM_STAT.hits+'</div></div><br clear="all" /><div style="padding-right:6px;"><div style="float:left;color:#969696;">хосты</div><div style="float:right;color:#003596;font:10px Tahoma;">'+oBM_STAT.hosts+'</div></div><br clear="all" /><div style="padding-right:6px;"><div style="float:left;color:#969696;">всего</div><div style="float:right;color:#003596;font:10px Tahoma;">'+oBM_STAT.total+'</div></div><br clear="all" /><div style="height:3px;"></div></div><div style="background:url(\'//i.bigmir.net/cnt/samples/diagonal/b59_bottom.gif\') no-repeat top;height:2px;line-height:1px;"> </div></div></td></tr></table>');
            }
            //-->
        </script>
        <script type="text/javascript" language="javascript"><!--
            bmN=navigator,bmD=document,bmD.cookie='b=b',i=0,bs=[],bm={o:1,v:16941760,s:16941760,t:0,c:bmD.cookie?1:0,n:Math.round((Math.random()* 1000000)),w:0};
            for(var f=self;f!=f.parent;f=f.parent)bm.w++;
            try{if(bmN.plugins&&bmN.mimeTypes.length&&(x=bmN.plugins['Shockwave Flash']))bm.m=parseInt(x.description.replace(/([a-zA-Z]|\s)+/,''));
            else for(var f=3;f<20;f++)if(eval('new ActiveXObject("ShockwaveFlash.ShockwaveFlash.'+f+'")'))bm.m=f}catch(e){;}
            try{bm.y=bmN.javaEnabled()?1:0}catch(e){;}
            try{bmS=screen;bm.v^=bm.d=bmS.colorDepth||bmS.pixelDepth;bm.v^=bm.r=bmS.width}catch(e){;}
            r=bmD.referrer.replace(/^w+:\/\//,'');if(r&&r.split('/')[0]!=window.location.host){bm.f=escape(r).slice(0,400);bm.v^=r.length}
            bm.v^=window.location.href.length;for(var x in bm) if(/^[ovstcnwmydrf]$/.test(x)) bs[i++]=x+bm[x];
            bmD.write('<sc'+'ript type="text/javascript" language="javascript" src="//c.bigmir.net/?'+bs.join('&')+'"></sc'+'ript>');
            //-->
        </script>
        <noscript>
            <a href="http://www.bigmir.net/" target="_blank"><img src="//c.bigmir.net/?v16941760&s16941760&t2" width="88" height="31" alt="bigmir)net TOP 100" title="bigmir)net TOP 100" border="0" /></a>
        </noscript>
        <!--bigmir)net TOP 100-->
    </div>
</div>
