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
            GxHtml::listDataEx(Source::model()->findAllAttributes(null, true)),
            array('prompt' => Yii::t('app', 'All'))
        ); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'url'); ?>
        <?php echo $form->textField($model, 'url', array('maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'active'); ?>
        <?php echo $form->textField($model, 'active'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'is_full'); ?>
        <?php echo $form->textField($model, 'is_full'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'is_combine'); ?>
        <?php echo $form->textField($model, 'is_combine'); ?>
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
