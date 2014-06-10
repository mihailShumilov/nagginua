<?php
/**
 * Created by PhpStorm.
 * User: godson
 * Date: 06.06.14
 * Time: 16:34
 */

$this->breadcrumbs = array(
    "News parsing test",
    Yii::t('app', 'Index'),
);

$this->renderPartial(
    '_form',
    array(
        'url'       => $url,
        'source_id' => $source_id
    )
);

if (isset($data) && !empty($data)):
    ?>
    <h2>Title: "<?php echo isset($data['title']) ? $data['title'] : "No title found"; ?>"</h2>
    <h3>Thumb</h3>
    <img src="<?php echo isset($data['thumb']) ? $data['thumb'] : ""; ?>"/>
    <h3>Content</h3>
    <div id="content"><?php echo isset($data['content']) ? $data['content'] : "No content found"; ?></div>
    <h3>Search content</h3>
    <div id="searchContent"><?php echo isset($data['searchContent']) ? $data['searchContent'] : ""; ?></div>
    <h3>Date - <?php echo date('Y-m-d H:i:s', isset($data['date']) ? $data['date'] : time()); ?></h3>

<?php
endif;