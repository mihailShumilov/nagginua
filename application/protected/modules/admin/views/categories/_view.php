<div class="view">

    <?php echo GxHtml::encode($data->getAttributeLabel('id    ')); ?>:
    <?php echo GxHtml::link(
        GxHtml::encode($data->id),
        array('view', 'id' => $data->id)
    ); ?>
    <br/>

    <?php echo GxHtml::encode($data->getAttributeLabel('name')); ?>:
    <?php echo GxHtml::encode($data->name); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('slug')); ?>:
    <?php echo GxHtml::encode($data->slug); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('keyword')); ?>:
    <?php echo GxHtml::encode($data->keyword); ?>
    <br/>

</div>