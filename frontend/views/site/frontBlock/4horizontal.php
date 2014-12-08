<div class="column-one-third">
    <h5 class="line"><span><?= \yii\helpers\Html::encode( $title ); ?></span></h5>

    <div class="outertight">
        <ul class="block">
            <?php foreach ($data as $item): ?>
                <li>
                    <a href="<?= $item->getLink(); ?>"><img src="<?= $item->getThumbLink( 'thumbNews' ); ?>"
                                                            alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"
                                                      class="alignleft"/></a>

                    <p>
                        <span><?= date( "d M, Y", strtotime( $item->created_at ) ); ?></span>
                        <a href="<?= $item->getLink(); ?>"><?= \yii\helpers\Html::encode( $item->title ); ?></a>
                    </p>
                    <!--                <span class="rating"><span style="width:80%;"></span></span>-->
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</div>