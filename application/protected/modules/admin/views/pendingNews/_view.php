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
    <?php echo GxHtml::encode($data->getAttributeLabel('title')); ?>:
    <?php echo GxHtml::encode($data->title); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('content')); ?>:
    <?php echo GxHtml::encode($data->content); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('search_content')); ?>:
    <?php echo GxHtml::encode($data->search_content); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('status')); ?>:
    <?php echo GxHtml::encode($data->status); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('group_hash')); ?>:
    <?php echo GxHtml::encode($data->group_hash); ?>
    <br/>
    <?php /*
        <?php echo GxHtml::encode($data->getAttributeLabel('created_at')); ?>:
                <?php echo GxHtml::encode($data->created_at); ?>
            <br/>
            <?php echo GxHtml::encode($data->getAttributeLabel('update_at')); ?>:
                <?php echo GxHtml::encode($data->update_at); ?>
            <br/>
        	*/
    ?>

</div>