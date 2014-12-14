<div class="column-one-third">
    <h5 class="line"><span><?= \yii\helpers\Html::encode( $title ); ?></span></h5>

    <div class="outertight">
        <ul class="block">
            <?php foreach ($data as $item): ?>
                <?= $this->render( 'news', [ "item" => $item ] ) ?>
            <?php endforeach; ?>
        </ul>
    </div>

</div>