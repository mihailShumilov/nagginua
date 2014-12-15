<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\CategoryWords */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="category-words-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'category_id' )->textInput() ?>

    <?= $form->field( $model, 'word' )->textInput( [ 'maxlength' => 255 ] ) ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
