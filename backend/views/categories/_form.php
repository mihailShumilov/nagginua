<?php

    use yii\helpers\Html;
    use yii\widgets\ActiveForm;

    /* @var $this yii\web\View */
    /* @var $model common\models\Categories */
    /* @var $form yii\widgets\ActiveForm */
?>

<div class="categories-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field( $model, 'name' )->textInput( [ 'maxlength' => 45 ] ) ?>

    <?= $form->field( $model, 'slug' )->textInput( [ 'maxlength' => 45 ] ) ?>

    <?= $form->field( $model,
        'parent_id' )->dropDownList( \yii\helpers\ArrayHelper::map( array_merge( [ 'id' => null, 'name' => null ],
        \common\models\Categories::find()->orderBy( 'name' )->asArray()->all() ),
        'id',
        'name' ), [ 'value' => $model->parent_id ] ) ?>

    <?= $form->field( $model, 'order' )->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton( $model->isNewRecord ? 'Create' : 'Update',
            [ 'class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary' ] ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
