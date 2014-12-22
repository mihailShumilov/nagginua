<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model common\models\Sources */

    $this->title                   = 'Update Sources: ' . ' ' . $model->id;
    $this->params['breadcrumbs'][] = [ 'label' => 'Sources', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = [ 'label' => $model->id, 'url' => [ 'view', 'id' => $model->id ] ];
    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="sources-update">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
