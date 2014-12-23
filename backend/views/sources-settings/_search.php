<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model backend\models\SourcesSettingsSearch */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="sources-settings-search">

    <?php $form = ActiveForm::begin( [
        'action' => [ 'index' ],
        'method' => 'get',
    ] ); ?>

    <?= $form->field( $model, 'id' ) ?>

    <?= $form->field( $model, 'source_id' ) ?>

    <?= $form->field( $model, 'name' ) ?>

    <?= $form->field( $model, 'value' ) ?>

    <div class="form-group">
        <?= Html::submitButton( 'Search', [ 'class' => 'btn btn-primary' ] ) ?>
        <?= Html::resetButton( 'Reset', [ 'class' => 'btn btn-default' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>