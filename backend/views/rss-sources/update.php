<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model common\models\RssSources */

    $this->title                   = 'Update Rss Sources: ' . ' ' . $model->id;
    $this->params['breadcrumbs'][] = [ 'label' => 'Rss Sources', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = [ 'label' => $model->id, 'url' => [ 'view', 'id' => $model->id ] ];
    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="rss-sources-update">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
