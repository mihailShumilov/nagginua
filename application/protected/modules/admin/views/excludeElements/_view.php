<div class="view">

    <?php echo GxHtml::encode($data->getAttributeLabel('id    ')); ?>:
    <?php echo GxHtml::link(
        GxHtml::encode($data->id),
        array('view', 'id' => $data->id)
    ); ?>
    <br/>

    <?php echo GxHtml::encode($data->getAttributeLabel('source_id')); ?>:
    <?php echo GxHtml::encode(GxHtml::valueEx($data->source)); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('pattern')); ?>:
    <?php echo GxHtml::encode($data->pattern); ?>
    <br/>

</div>