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