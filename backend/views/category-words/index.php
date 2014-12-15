<?php

    use yii\helpers\Html;
    use yii\grid\GridView;

    /* @var $this yii\web\View */
    /* @var $searchModel backend\models\CategoryWordsSearch */
    /* @var $dataProvider yii\data\ActiveDataProvider */

    $this->title                   = 'Category Words';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-words-index">

    <h1><?= Html::encode( $this->title ) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a( 'Create Category Words', [ 'create' ], [ 'class' => 'btn btn-success' ] ) ?>
    </p>

    <?= GridView::widget( [
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            [ 'class' => 'yii\grid\SerialColumn' ],
            'id',
            'category_id',
            'word',
            [ 'class' => 'yii\grid\ActionColumn' ],
        ],
    ] ); ?>

</div>
