<?php

    use yii\helpers\Html;


    /* @var $this yii\web\View */
    /* @var $model common\models\Npn */

    $this->title                   = 'Create Npn';
    $this->params['breadcrumbs'][] = [ 'label' => 'Npns', 'url' => [ 'index' ] ];
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="npn-create">

    <h1><?= Html::encode( $this->title ) ?></h1>

    <?= $this->render( '_form', [
        'model' => $model,
    ] ) ?>

</div>
