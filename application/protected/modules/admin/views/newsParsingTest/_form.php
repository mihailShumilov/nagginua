<div class="form">


    <?php     $form = $this->beginWidget(
        'GxActiveForm',
        array(
            'id' => 'npt-form',
            'enableAjaxValidation' => false,
        )
    );
    ?>
    <div class="row">
        <?php echo $form->dropDownList(
            Source::model(),
            'id',
            CHtml::ListData(Source::model()->findAll(), 'id', 'label'),
            array('empty' => 'Select a source', 'options' => array($source_id => array('selected' => true)))
        ); ?>
        <?php echo $form->error(Source::model(), 'id'); ?>
    </div>
    <div class="row">
        <input type="text" name="url" width="255" value="<?php echo $url; ?>"/>
    </div>


    <?php
    echo GxHtml::submitButton(Yii::t('app', 'Parse'));
    $this->endWidget();
    ?>
</div>