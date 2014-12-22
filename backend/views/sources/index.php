<?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $searchModel backend\models\SourcesSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title                   = 'Sources';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="sources-index">

    <h1><?= Html::encode( $this->title ) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a( 'Create Sources', [ 'create' ], [ 'class' => 'btn btn-success' ] ) ?>
    </p>

    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [ 'class' => 'yii\grid\SerialColumn' ],
            'id',
            'label',
            'url:url',
            'category_pattern',
            'news_pattern',
            // 'thumb_pattern',
            // 'active',
            // 'created_at',
            // 'updated_at',

            [ 'class' => 'yii\grid\ActionColumn' ],
        ],
    ] ); ?>

</div>
