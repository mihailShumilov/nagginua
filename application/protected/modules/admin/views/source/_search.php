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
        <?php echo $form->label($model, 'label'); ?>
        <?php echo $form->textField($model, 'label', array('maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'url'); ?>
        <?php echo $form->textField($model, 'url', array('maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'category_pattern'); ?>
        <?php echo $form->textField($model, 'category_pattern', array('maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'news_pattern'); ?>
        <?php echo $form->textField($model, 'news_pattern', array('maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'thumb_pattern'); ?>
        <?php echo $form->textField($model, 'thumb_pattern', array('maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'active'); ?>
        <?php echo $form->textField($model, 'active'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'created_at'); ?>
        <?php echo $form->textField($model, 'created_at'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'updated_at'); ?>
        <?php echo $form->textField($model, 'updated_at'); ?>
    </div>

    <div class="row buttons">
        <?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
