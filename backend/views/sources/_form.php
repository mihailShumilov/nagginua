<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\Sources */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="sources-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'label' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'url' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'category_pattern' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'news_pattern' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'thumb_pattern' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <?= $form->field( $model, 'active' )->textInput() ?>

    <?= $form->field( $model, 'created_at' )->textInput() ?>

    <?= $form->field( $model, 'updated_at' )->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
