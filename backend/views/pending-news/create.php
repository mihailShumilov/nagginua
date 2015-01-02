<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model common\models\PendingNews */

    $this->title                   = 'Create Pending News';
    $this->params['breadcrumbs'][] = [ 'label' => 'Pending News', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pending-news-create">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
