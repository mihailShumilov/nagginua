<h1>Parser test</h1>

<?php echo \yii\helpers\Html::beginForm(); ?>
<p>
    <?php
        echo \yii\helpers\Html::dropDownList( "Source", null,
            \yii\helpers\ArrayHelper::map( \common\models\Sources::find()->asArray()->all(), 'id', 'label' ) );
    ?>
</p>
<p>
    <?php echo \yii\helpers\Html::input( "text", "url" ); ?>
</p>
<p>
    <?php echo \yii\helpers\Html::button( "Parse", [ "type" => "submit" ] ); ?>
</p>
<?php echo \yii\helpers\Html::endForm(); ?>

<?php if (isset( $parserResult )): ?>
    <h1>Title:</h1>
    <p><?= $parserResult['title']; ?></p>
    <h1>Thumb:</h1>
    <p><img src="<?= $parserResult['thumb']; ?>"/></p>
    <h1>Search content:</h1>
    <p><?= $parserResult['searchContent']; ?></p>
    <h1>Content:</h1>
    <p><?= $parserResult['content']; ?></p>
<?php endif; ?>