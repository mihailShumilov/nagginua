<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model backend\models\PendingNewsSearch */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="pending-news-search">

    <?php $form = ActiveForm::begin( [
        'action' => [ 'index' ],
        'method' => 'get',
    ] ); ?>

    <?= $form->field( $model, 'id' ) ?>

    <?= $form->field( $model, 'source_id' ) ?>

    <?= $form->field( $model, 'pq_id' ) ?>

    <?= $form->field( $model, 'title' ) ?>

    <?= $form->field( $model, 'content' ) ?>

    <?php // echo $form->field($model, 'search_content') ?>

    <?php // echo $form->field($model, 'thumb_src') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'group_hash') ?>

    <?php // echo $form->field($model, 'processed') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'update_at') ?>

    <div class="form-group">
        <?= Html::submitButton( 'Search', [ 'class' => 'btn btn-primary' ] ) ?>
        <?= Html::resetButton( 'Reset', [ 'class' => 'btn btn-default' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
