<?php

$this->breadcrumbs = array(
    $model->label(2) => array('index'),
    GxHtml::valueEx($model),
);

$this->menu = array(
    array('label' => Yii::t('app', 'List') . ' ' . $model->label(2), 'url' => array('index')),
    array('label' => Yii::t('app', 'Create') . ' ' . $model->label(), 'url' => array('create')),
    array('label' => Yii::t('app', 'Update') . ' ' . $model->label(), 'url' => array('update', 'id' => $model->id)),
    array(
        'label'       => Yii::t('app', 'Delete') . ' ' . $model->label(),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array('delete', 'id' => $model->id),
            'confirm' => 'Are you sure you want to delete this item?'
        )
    ),
    array('label' => Yii::t('app', 'Manage') . ' ' . $model->label(2), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('app', 'View') . ' ' . GxHtml::encode($model->label()) . ' ' .
        GxHtml::encode(GxHtml::valueEx($model)); ?></h1>

<?php $this->widget(
    'zii.widgets.CDetailView',
    array(
        'data'       => $model,
        'attributes' => array(
            'id',
            'label',
            'url',
            'category_pattern',
            'news_pattern',
            'thumb_pattern',
            'active',
            'created_at',
            'updated_at',
        ),
    )
); ?>

<h2><?php echo GxHtml::encode($model->getRelationLabel('contentStopWords'));
    ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->contentStopWords as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(
        GxHtml::encode(GxHtml::valueEx($relatedModel)),
        array('contentStopWords/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true))
    );
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>                <h2><?php echo GxHtml::encode($model->getRelationLabel('parserQueues'));
    ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->parserQueues as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(
        GxHtml::encode(GxHtml::valueEx($relatedModel)),
        array('parserQueue/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true))
    );
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>                <h2><?php echo GxHtml::encode($model->getRelationLabel('pendingNews'));
    ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->pendingNews as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(
        GxHtml::encode(GxHtml::valueEx($relatedModel)),
        array('pendingNews/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true))
    );
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>                <h2><?php echo GxHtml::encode($model->getRelationLabel('titleStopWords'));
    ?></h2>
<?php
echo GxHtml::openTag('ul');
foreach ($model->titleStopWords as $relatedModel) {
    echo GxHtml::openTag('li');
    echo GxHtml::link(
        GxHtml::encode(GxHtml::valueEx($relatedModel)),
        array('titleStopWords/view', 'id' => GxActiveRecord::extractPkValue($relatedModel, true))
    );
    echo GxHtml::closeTag('li');
}
echo GxHtml::closeTag('ul');
?>