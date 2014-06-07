<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 06.06.14
 * Time: 16:32
 */
class NewsParsingTestController extends GxController
{
    public function actionIndex()
    {
        $data = array();

        if (isset($_POST['Source'])) {
            $source = Source::model()->findByPk($_POST['Source']['id']);
            $html   = PageLoader::load($_POST['url']);
            $np     = new NewsParser(ParserQueue::model()->find());
            $data   = $np->parse($html, $_POST['url'], $source);
        }

        $this->render(
            'index',
            array(
                'data' => $data,
                'url' => isset($_POST['url']) ? $_POST['url'] : null,
                'source_id' => isset($_POST['Source']) ? $_POST['Source']['id'] : null
            )
        );
    }
} 