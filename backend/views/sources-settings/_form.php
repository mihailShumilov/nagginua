<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\SourcesSettings */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="sources-settings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'source_id' )->textInput() ?>

    <?= $form->field( $model, 'name' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'value' )->textarea( [ 'rows' => 6 ] ) ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
