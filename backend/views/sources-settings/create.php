<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model common\models\SourcesSettings */

    $this->title                   = 'Create Sources Settings';
    $this->params['breadcrumbs'][] = [ 'label' => 'Sources Settings', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="sources-settings-create">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
