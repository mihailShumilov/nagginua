<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\RssSources */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="rss-sources-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'source_id' )->textInput() ?>

    <?= $form->field( $model, 'url' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'active' )->textInput() ?>

    <?= $form->field( $model, 'is_full' )->textInput() ?>

    <?= $form->field( $model, 'is_combine' )->textInput() ?>

    <?= $form->field( $model, 'created_at' )->textInput() ?>

    <?= $form->field( $model, 'updated_at' )->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
