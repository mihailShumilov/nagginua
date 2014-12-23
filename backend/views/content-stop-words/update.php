<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model common\models\ContentStopWords */

    $this->title                   = 'Update Content Stop Words: ' . ' ' . $model->id;
    $this->params['breadcrumbs'][] = [ 'label' => 'Content Stop Words', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = [ 'label' => $model->id, 'url' => [ 'view', 'id' => $model->id ] ];
    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="content-stop-words-update">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
