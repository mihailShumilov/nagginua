<div class="form">


    <?php     $form = $this->beginWidget(
        'GxActiveForm',
        array(
            'id' => 'sources-settings-form',
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
            GxHtml::listDataEx(Sources::model()->findAllAttributes(null, true))
        ); ?>
        <?php echo $form->error($model, 'source_id'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('maxlength' => 255)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'value'); ?>
        <?php echo $form->textArea($model, 'value'); ?>
        <?php echo $form->error($model, 'value'); ?>
    </div>
    <!-- row -->


    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->