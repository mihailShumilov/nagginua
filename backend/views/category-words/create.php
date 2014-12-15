<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model common\models\CategoryWords */

    $this->title                   = 'Create Category Words';
    $this->params['breadcrumbs'][] = [ 'label' => 'Category Words', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-words-create">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
