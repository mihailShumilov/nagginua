<li class="<?= isset( $class ) ? $class : ""; ?>">
    <a href="<?= $item->getLink(); ?>"><img src="<?= $item->getThumbLink( 'thumbNews' ); ?>"
                                            alt="<?= \yii\helpers\Html::encode( $item->title ); ?>"
                                            class="alignleft"/></a>

    <p>
        <span><?= date( "d M, Y", strtotime( $item->created_at ) ); ?></span>
        <a href="<?= \yii\helpers\Html::encode( $item->getLink() ); ?>"><?= \yii\helpers\Html::encode( ( mb_strlen( $item->title,
                    'utf-8' ) > 53 ) ? mb_substr( $item->title, 0, 50, 'utf-8' ) . "..." : $item->title ); ?></a>
    </p>
</li>