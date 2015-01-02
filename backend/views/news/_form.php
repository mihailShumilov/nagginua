<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\News */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'title' )->textarea( [ 'rows' => 6 ] ) ?>

    <?= $form->field( $model, 'thumb' )->textarea( [ 'rows' => 6 ] ) ?>

    <?= $form->field( $model, 'status' )->dropDownList( [
        'in_process' => 'In process',
        'done'       => 'Done',
        'deleted'    => 'Deleted',
    ], [ 'prompt' => '' ] ) ?>

    <?= $form->field( $model, 'created_at' )->textInput() ?>

    <?= $form->field( $model, 'updated_at' )->textInput() ?>

    <?= $form->field( $model, 'cnt' )->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
