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
    <?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
    <?php echo GxHtml::encode($data->name); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('value')); ?>:
    <?php echo GxHtml::encode($data->value); ?>
    <br/>

</div>