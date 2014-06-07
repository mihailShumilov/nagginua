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
        <?php echo $form->label($model, 'pattern'); ?>
        <?php echo $form->textArea($model, 'pattern'); ?>
    </div>

    <div class="row buttons">
        <?php echo GxHtml::submitButton(Yii::t('app', 'Search')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
