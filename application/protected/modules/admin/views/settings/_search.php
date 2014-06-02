<div class="wide form">

    <?php $form = $this->beginWidget(
        'GxActiveForm',
        array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
        )
    ); ?>

    <div class="row">
        <?php echo $form->label($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'value'); ?>
        <?php echo $form->textField($model, 'value', array('maxlength' => 255)); ?>
    </div>

    <div class="row buttons">
        <?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
