<!-- Header -->
<header id="header">
    <div class="container">
        <div class="column">
            <div class="logo">
                <a href="/"><img src="/img/logo.png" alt="Новости"/></a>
            </div>

            <div class="search">
                <!--                <form action="" method="post">-->
                <!--                    <input type="text" value="Поиск." onblur="if(this.value=='') this.value='Поиск.';"-->
                <!--                           onfocus="if(this.value=='Поиск.') this.value='';" class="ft"/>-->
                <!--                    <input type="submit" value="" class="fs">-->
                <!--                </form>-->
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

            </nav>
            <!-- /Nav -->
        </div>
    </div>
</header>
<!-- /Header -->