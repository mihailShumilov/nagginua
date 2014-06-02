<div class="wide form">

    <?php $form = $this->beginWidget(
        'GxActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
        )
    ); ?>

    <div class="row">
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'source_id'); ?>
        <?php echo $form->dropDownList(
            $model,
            'source_id',
            GxHtml::listDataEx(Sources::model()->findAllAttributes(null, true)),
            array('prompt' => Yii::t('app', 'All'))
        ); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'word'); ?>
        <?php echo $form->textField($model, 'word', array('maxlength' => 255)); ?>
    </div>

    <div class="row buttons">
        <?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
