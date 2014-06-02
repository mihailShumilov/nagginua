<div class="form">


    <?php     $form = $this->beginWidget(
        'GxActiveForm',
        array(
            'id' => 'categories-form',
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
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('maxlength' => 45)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'slug'); ?>
        <?php echo $form->textField($model, 'slug', array('maxlength' => 45)); ?>
        <?php echo $form->error($model, 'slug'); ?>
    </div>
    <!-- row -->
    <div class="row">
        <?php echo $form->labelEx($model, 'keyword'); ?>
        <?php echo $form->textArea($model, 'keyword'); ?>
        <?php echo $form->error($model, 'keyword'); ?>
    </div>
    <!-- row -->


    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Save'));
    $this->endWidget();
    ?>
</div><!-- form -->