<div class="form">


    <?php     $form = $this->beginWidget(
        'GxActiveForm',
        array(
            'id' => 'rss-sources-form',
            'enableAjaxValidation' => false,
        )
    );
    ?>

    <p class="note">
        <?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t(
            'app',
            'are required'
        ); ?>        .
    </p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'source_id'); ?>
        <?php echo $form->dropDownList(
            $model,
            'source_id',
            GxHtml::listDataEx(Source::model()->findAllAttributes(null, true))
        ); ?>
        <?php echo $form->error($model, 'source_id'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'url'); ?>
        <?php echo $form->textField($model, 'url', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'url'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'active'); ?>
        <?php echo $form->textField($model, 'active'); ?>
        <?php echo $form->error($model, 'active'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'is_full'); ?>
        <?php echo $form->textField($model, 'is_full'); ?>
        <?php echo $form->error($model, 'is_full'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'is_combine'); ?>
        <?php echo $form->textField($model, 'is_combine'); ?>
        <?php echo $form->error($model, 'is_combine'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'created_at'); ?>
        <?php echo $form->textField($model, 'created_at'); ?>
        <?php echo $form->error($model, 'created_at'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'updated_at'); ?>
        <?php echo $form->textField($model, 'updated_at'); ?>
        <?php echo $form->error($model, 'updated_at'); ?>
    </div>
    <!-- row -->


    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->