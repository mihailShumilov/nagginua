<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model common\models\RssSources */

    $this->title                   = 'Create Rss Sources';
    $this->params['breadcrumbs'][] = [ 'label' => 'Rss Sources', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="rss-sources-create">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
