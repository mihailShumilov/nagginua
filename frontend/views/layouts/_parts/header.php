<!-- Header -->
<header id="header">
    <div class="container">
        <div class="column">
            <div class="logo">
                <a href="/"><img src="/img/logo.png" alt="Новости"/></a>
            </div>

            <div class="search">
                <form action="" method="post">
                    <input type="text" value="Поиск." onblur="if(this.value=='') this.value='Поиск.';"
                           onfocus="if(this.value=='Поиск.') this.value='';" class="ft"/>
                    <input type="submit" value="" class="fs">
                </form>
            </div>

            <!-- Nav -->
            <nav id="nav">
                <ul class="sf-menu">
                <?php if ($categories = \common\models\Categories::find()->all()): ?>

                        <?php foreach ($categories as $category): ?>
                            <li>
                                <a href="<?= $category->getLink(); ?>"><?= \yii\helpers\Html::encode( $category->name ); ?></a>
                            </li>
                        <?php endforeach; ?>

                <?php endif; ?>
                </ul>

                <!--                <ul class="sf-menu">-->
                <!--                    <li class="current"><a href="index.html">Home.</a></li>-->
                <!--                    <li>-->
                <!--                        <a href="#">Pages.</a>-->
                <!--                        <ul>-->
                <!--                            <li><i class="icon-right-open"></i><a href="leftsidebar.html">Left Sidebar.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="reviews.html">Reviews.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="single.html">Single News.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="features.html">Features.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="contact.html">Contact.</a></li>-->
                <!--                        </ul>-->
                <!--                    </li>-->
                <!--                    <li><a href="/category/all">World.</a></li>-->
                <!--                    <li><a href="reviews.html">Business.</a></li>-->
                <!--                    <li><a href="reviews.html">Politics.</a></li>-->
                <!--                    <li>-->
                <!--                        <a href="reviews.html">Sports.</a>-->
                <!--                        <ul>-->
                <!--                            <li><i class="icon-right-open"></i><a href="#">Football.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="#">Running.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="#">Tennis.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="#">Fitness.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="#">Golf.</a></li>-->
                <!--                            <li><i class="icon-right-open"></i><a href="#">Motosport.</a></li>-->
                <!--                        </ul>-->
                <!--                    </li>-->
                <!--                    <li><a href="reviews.html">Health.</a></li>-->
                <!--                    <li><a href="reviews.html">Science.</a></li>-->
                <!--                    <li><a href="reviews.html">Music.</a></li>-->
                <!--                    <li><a href="reviews.html">Tech.</a></li>-->
                <!--                </ul>-->

            </nav>
            <!-- /Nav -->
        </div>
    </div>
</header>
<!-- /Header -->