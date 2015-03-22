<!-- Header -->
<header id="header">
    <div class="container">
        <div class="column">
            <div class="logo">
                <a href="/"><img src="/img/logo.png" alt="Новости"/></a>
            </div>

            <div class="search">
                <form action="/search" method="get">
                    <input type="text" value="<?php if (isset( $this->params['searchQuery'] )) {
                        echo \yii\helpers\Html::encode( $this->params['searchQuery'] );
                    } else {
                        echo "Поиск.";
                    } ?>" onblur="if(this.value=='') {this.value='Поиск.';
}"
                           onfocus="if(this.value=='Поиск.') {this.value='';
}" class="ft" name="q"/>
                    <input type="submit" value="" class="fs">
                </form>
            </div>

            <!-- Nav -->
            <nav id="nav">
                <ul class="sf-menu">
                    <?php if ($categories = \common\models\Categories::find()->where( 'parent_id IS NULL' )->with( 'child' )->orderBy( 'order ASC' )->all()): ?>
                        <?php $current = \common\models\Categories::findOne( [ 'slug' => isset( Yii::$app->requestedParams[0] ) ? Yii::$app->requestedParams[0] : 'all' ] ); ?>


                        <?php foreach ($categories as $category): ?>

                            <li <?php if ($current && ( $current->id == $category->id )): ?>class="current"<?php endif; ?>>
                                <a href="<?= $category->getLink(); ?>"><?= \yii\helpers\Html::encode( $category->name ); ?></a>
                                <?php if ($child = $category->child): ?>
                                    <ul>
                                        <?php foreach ($category->child as $subcat): ?>
                                            <li>
                                                <i class="icon-right-open <?php if ($current && ( $current->id == $subcat->id )): ?>current<?php endif; ?>"></i><a
                                                    href="<?= $subcat->getLink(); ?>"><?= \yii\helpers\Html::encode( $subcat->name ); ?></a>
                                            </li>
                                        <?php endforeach; ?>

                                    </ul>
                                <?php endif; ?>
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