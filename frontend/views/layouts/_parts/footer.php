<footer id="footer">
    <div class="container">
        <div class="column-one-fourth">
            <h5 class="line"><span>Твиты.</span></h5>

            <div id="tweets"></div>
        </div>
        <div class="column-one-fourth">
            <h5 class="line"><span>Навигация.</span></h5>
            <ul class="footnav">
                <?php if ($categories = \common\models\Categories::find()->all()): ?>

                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="<?= $category->getLink(); ?>"><i
                                    class="icon-right-open"></i><?= \yii\helpers\Html::encode( $category->name ); ?></a>
                        </li>
                    <?php endforeach; ?>

                <?php endif; ?>
            </ul>
        </div>
        <div class="column-one-fourth">
            <h5 class="line"><span>Теги</span></h5>

            <ul>
                <?php if ($tags = \common\models\Tags::getPopular()): ?>
                    <?php foreach ($tags as $tag): ?>
                        <li><?= \yii\helpers\Html::encode( $tag->name ); ?></li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <div class="column-one-fourth">
            <h5 class="line"><span>О нас.</span></h5>

            <p>Данный проект призван упростить жизнь людям которые ищут новости в сети</p>
            <!--            <p>Проект собирает статьи с  различных сайтов затем автоматическим алгоритмом группирует дубликаты статей (или похожие новости) и публикует их на сайте</p>-->
            <p>Проект не является журналистским изданием — это только сборщик и группировщик новостей</p>
            <!--            <p>На текущий момент проект на альфа стадии — это означает что возможны нестабильности в работе а также ошибки</p>-->
            <p>Если у Вас есть вопросы / предложения / пожелания / замечания ждем Ваших писем на <a
                    href="mailto:mschumilow@gmail.com">mschumilow@gmail.com</a></p>
        </div>
        <p class="copyright">&copy; <?= date( "Y" ) ?>. Mihail Shumilov</p>
    </div>
</footer>