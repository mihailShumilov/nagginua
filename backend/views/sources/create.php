<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model common\models\Sources */

    $this->title                   = 'Create Sources';
    $this->params['breadcrumbs'][] = [ 'label' => 'Sources', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="sources-create">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
