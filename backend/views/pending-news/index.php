<?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $searchModel backend\models\PendingNewsSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title                   = 'Pending News';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="pending-news-index">

    <h1><?= Html::encode( $this->title ) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a( 'Create Pending News', [ 'create' ], [ 'class' => 'btn btn-success' ] ) ?>
    </p>

    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [ 'class' => 'yii\grid\SerialColumn' ],
            'id',
            'source_id',
            'pq_id',
            'title:ntext',
            'content:ntext',
            // 'search_content:ntext',
            // 'thumb_src:ntext',
            // 'status',
            // 'group_hash',
            // 'processed',
            // 'created_at',
            // 'update_at',

            [ 'class' => 'yii\grid\ActionColumn' ],
        ],
    ] ); ?>

</div>
