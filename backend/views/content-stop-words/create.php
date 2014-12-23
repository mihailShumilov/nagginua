<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model common\models\ContentStopWords */

    $this->title                   = 'Create Content Stop Words';
    $this->params['breadcrumbs'][] = [ 'label' => 'Content Stop Words', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-stop-words-create">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
