<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model common\models\SourcesSettings */

    $this->title                   = 'Update Sources Settings: ' . ' ' . $model->name;
    $this->params['breadcrumbs'][] = [ 'label' => 'Sources Settings', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = [ 'label' => $model->name, 'url' => [ 'view', 'id' => $model->id ] ];
    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="sources-settings-update">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
