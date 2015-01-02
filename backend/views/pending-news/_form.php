<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\PendingNews */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="pending-news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'source_id' )->textInput() ?>

    <?= $form->field( $model, 'pq_id' )->textInput() ?>

    <?= $form->field( $model, 'title' )->textarea( [ 'rows' => 6 ] ) ?>

    <?= $form->field( $model, 'content' )->textarea( [ 'rows' => 6 ] ) ?>

    <?= $form->field( $model, 'search_content' )->textarea( [ 'rows' => 6 ] ) ?>

    <?= $form->field( $model, 'thumb_src' )->textarea( [ 'rows' => 6 ] ) ?>

    <?= $form->field( $model, 'status' )->dropDownList( [ 'pending'    => 'Pending',
                                                          'in_process' => 'In process',
                                                          'approved'   => 'Approved',
                                                          'rejected'   => 'Rejected',
                                                          'suspended'  => 'Suspended',
    ], [ 'prompt' => '' ] ) ?>

    <?= $form->field( $model, 'group_hash' )->textInput( [ 'maxlength' => 45 ] ) ?>

    <?= $form->field( $model, 'processed' )->textInput() ?>

    <?= $form->field( $model, 'created_at' )->textInput() ?>

    <?= $form->field( $model, 'update_at' )->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
