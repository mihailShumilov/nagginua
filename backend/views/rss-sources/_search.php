<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model backend\models\RssSourcesSearch */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="rss-sources-search">

    <?php $form = ActiveForm::begin( [
        'action' => [ 'index' ],
        'method' => 'get',
    ] ); ?>

    <?= $form->field( $model, 'id' ) ?>

    <?= $form->field( $model, 'source_id' ) ?>

    <?= $form->field( $model, 'url' ) ?>

    <?= $form->field( $model, 'active' ) ?>

    <?= $form->field( $model, 'is_full' ) ?>

    <?php // echo $form->field($model, 'is_combine') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php echo $form->field( $model, 'category_id' ) ?>

    <div class="form-group">
        <?= Html::submitButton( 'Search', [ 'class' => 'btn btn-primary' ] ) ?>
        <?= Html::resetButton( 'Reset', [ 'class' => 'btn btn-default' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
