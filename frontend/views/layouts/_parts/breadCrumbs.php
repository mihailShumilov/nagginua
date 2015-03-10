<div class="breadcrumbs column">
    <p>
        <?php if (isset( $this->params['breadcrumbs'] )): ?>
            <?php foreach ($this->params['breadcrumbs'] as $key => $item): ?>
                <?php if ($key > 0): ?> \\ <?php endif; ?><?php if (isset( $item['url'] )): ?><a href="<?= $item['url'] ?>"><?php endif; ?><?= \yii\helpers\Html::encode( $item['label'] ); ?><?php if (isset( $item['url'] )): ?></a><?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </p>
</div>