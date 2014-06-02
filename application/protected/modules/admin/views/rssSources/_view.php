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
    <?php echo GxHtml::encode($data->getAttributeLabel('url')); ?>:
    <?php echo GxHtml::encode($data->url); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('active')); ?>:
    <?php echo GxHtml::encode($data->active); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('is_full')); ?>:
    <?php echo GxHtml::encode($data->is_full); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('is_combine')); ?>:
    <?php echo GxHtml::encode($data->is_combine); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('created_at')); ?>:
    <?php echo GxHtml::encode($data->created_at); ?>
    <br/>
    <?php /*
        <?php echo GxHtml::encode($data->getAttributeLabel('updated_at')); ?>:
                <?php echo GxHtml::encode($data->updated_at); ?>
            <br/>
        	*/
    ?>

</div>