<li>
    <a href="<?= $item->getLink(); ?>" class="title"><?= \yii\helpers\Html::encode( ( mb_strlen( $item->title,
                'utf-8' ) > 83 ) ? mb_substr( $item->title, 0, 80, 'utf-8' ) . "..." : $item->title ); ?></a>
                        <span class="meta"><?= date( "d M, Y", strtotime( $item->created_at ) ); ?>.
                            <?php if ($categories = $item->getCategoryList()): ?>
                                <?php foreach ($categories as $category): ?>
                                    \\ <a href="<?= $category->getLink(); ?>"><?= $category->name; ?></a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </span>
    <!--    <span class="rating"><span style="width:70%;"></span></span>-->
</li>