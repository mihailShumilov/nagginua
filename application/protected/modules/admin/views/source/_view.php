<div class="view">

    <?php echo GxHtml::encode($data->getAttributeLabel('id    ')); ?>:
    <?php echo GxHtml::link(
        GxHtml::encode($data->id),
        array('view', 'id' => $data->id)
    ); ?>
    <br/>

    <?php echo GxHtml::encode($data->getAttributeLabel('label')); ?>:
    <?php echo GxHtml::encode($data->label); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('url')); ?>:
    <?php echo GxHtml::encode($data->url); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('category_pattern')); ?>:
    <?php echo GxHtml::encode($data->category_pattern); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('news_pattern')); ?>:
    <?php echo GxHtml::encode($data->news_pattern); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('thumb_pattern')); ?>:
    <?php echo GxHtml::encode($data->thumb_pattern); ?>
    <br/>
    <?php echo GxHtml::encode($data->getAttributeLabel('active')); ?>:
    <?php echo GxHtml::encode($data->active); ?>
    <br/>
    <?php /*
        <?php echo GxHtml::encode($data->getAttributeLabel('created_at')); ?>:
                <?php echo GxHtml::encode($data->created_at); ?>
            <br/>
            <?php echo GxHtml::encode($data->getAttributeLabel('updated_at')); ?>:
                <?php echo GxHtml::encode($data->updated_at); ?>
            <br/>
        	*/
    ?>

</div>