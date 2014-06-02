<div class="view">

    <?php echo GxHtml::encode($data->getAttributeLabel('name    ')); ?>:
    <?php echo GxHtml::link(
        GxHtml::encode($data->name),
        array('view', 'id' => $data->name)
    ); ?>
    <br/>

    <?php echo GxHtml::encode($data->getAttributeLabel('value')); ?>:
    <?php echo GxHtml::encode($data->value); ?>
    <br/>

</div>