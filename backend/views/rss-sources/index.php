<?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $searchModel backend\models\RssSourcesSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title                   = 'Rss Sources';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="rss-sources-index">

    <h1><?= Html::encode( $this->title ) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a( 'Create Rss Sources', [ 'create' ], [ 'class' => 'btn btn-success' ] ) ?>
    </p>

    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [ 'class' => 'yii\grid\SerialColumn' ],
            'id',
            'source_id',
            'url:url',
            'active',
            'is_full',
            // 'is_combine',
            // 'created_at',
            // 'updated_at',

            [ 'class' => 'yii\grid\ActionColumn' ],
        ],
    ] ); ?>

</div>
