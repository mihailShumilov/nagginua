<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\Npn */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="npn-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'news_id' )->textInput() ?>

    <?= $form->field( $model, 'pending_news_id' )->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
