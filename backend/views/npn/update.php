<?php

    use yii\helpers\Html;

    /* @var $this yii\web\View */
    /* @var $model common\models\Npn */

    $this->title                   = 'Update Npn: ' . ' ' . $model->news_id;
    $this->params['breadcrumbs'][] = [ 'label' => 'Npns', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = [ 'label' => $model->news_id,
                                       'url'   => [
                                           'view',
                                           'news_id'         => $model->news_id,
                                           'pending_news_id' => $model->pending_news_id
                                       ]
    ];
    $this->params['breadcrumbs'][] = 'Update';
?>
<div class="npn-update">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
