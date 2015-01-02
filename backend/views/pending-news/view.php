<?php

    use yii\helpers\Html;
    use yii\widgets\DetailView;

    /* @var $this yii\web\View */
    /* @var $model common\models\PendingNews */

    $this->title                   = $model->title;
    $this->params['breadcrumbs'][] = [ 'label' => 'Pending News', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pending-news-view">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <p>
        <?= Html::a( 'Update', [ 'update', 'id' => $model->id ], [ 'class' => 'btn btn-primary' ] ) ?>
        <?= Html::a( 'Delete', [ 'delete', 'id' => $model->id ], [
            'class' => 'btn btn-danger',
            'data'  => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method'  => 'post',
            ],
        ] ) ?>
    </p>

    <?= DetailView::widget( [
        'model'      => $model,
        'attributes' => [
            'id',
            'source_id',
            'pq_id',
            'title:ntext',
            'content:ntext',
            'search_content:ntext',
            'thumb_src:ntext',
            'status',
            'group_hash',
            'processed',
            'created_at',
            'update_at',
        ],
    ] ) ?>

</div>
