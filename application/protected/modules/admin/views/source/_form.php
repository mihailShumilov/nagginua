<div class="form">


    <?php     $form = $this->beginWidget(
        'GxActiveForm',
        array(
            'id' => 'source-form',
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
        <?php echo $form->labelEx($model, 'label'); ?>
        <?php echo $form->textField($model, 'label', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'label'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'url'); ?>
        <?php echo $form->textField($model, 'url', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'url'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'category_pattern'); ?>
        <?php echo $form->textField($model, 'category_pattern', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'category_pattern'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'news_pattern'); ?>
        <?php echo $form->textField($model, 'news_pattern', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'news_pattern'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'thumb_pattern'); ?>
        <?php echo $form->textField($model, 'thumb_pattern', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'thumb_pattern'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'active'); ?>
        <?php echo $form->textField($model, 'active'); ?>
        <?php echo $form->error($model, 'active'); ?>
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

    <label><?php echo GxHtml::encode($model->getRelationLabel('contentStopWords'));
        ?></label>
    <?php echo $form->checkBoxList(
        $model,
        'contentStopWords',
        GxHtml::encodeEx(GxHtml::listDataEx(ContentStopWords::model()->findAllAttributes(null, true)), false, true)
    ); ?>
    <label><?php echo GxHtml::encode($model->getRelationLabel('parserQueues'));
        ?></label>
    <?php echo $form->checkBoxList(
        $model,
        'parserQueues',
        GxHtml::encodeEx(GxHtml::listDataEx(ParserQueue::model()->findAllAttributes(null, true)), false, true)
    ); ?>
    <label><?php echo GxHtml::encode($model->getRelationLabel('pendingNews'));
        ?></label>
    <?php echo $form->checkBoxList(
        $model,
        'pendingNews',
        GxHtml::encodeEx(GxHtml::listDataEx(PendingNews::model()->findAllAttributes(null, true)), false, true)
    ); ?>
    <label><?php echo GxHtml::encode($model->getRelationLabel('titleStopWords'));
        ?></label>
    <?php echo $form->checkBoxList(
        $model,
        'titleStopWords',
        GxHtml::encodeEx(GxHtml::listDataEx(TitleStopWords::model()->findAllAttributes(null, true)), false, true)
    ); ?>

    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->