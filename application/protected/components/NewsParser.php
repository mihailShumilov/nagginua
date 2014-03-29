<?php
Yii::import('application.extensions.readability.Readability');

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 08.03.14
 * Time: 23:43
 */
class NewsParser extends CApplicationComponent
{

    /**
     * @var Source Sources
     */
    private $source;
    private $url;
    private $parserQueue;

    public function __construct(ParserQueue $pq)
    {
        $pq->status = ParserQueue::STATUS_INPROCESS;
        $pq->save();
        $this->source      = $pq->source;
        $this->url         = $this->prepareUrl($pq->url);
        $this->parserQueue = $pq;
    }

    public function run()
    {
//        echo "Try parse `{$this->url}`\n";
        if ($html = PageLoader::load($this->url)) {
            if (function_exists('tidy_parse_string')) {
                $tidy = tidy_parse_string($html, array(), 'UTF8');
                $tidy->cleanRepair();
                $html = $tidy->value;
            }

            $readability                          = new Readability($html, $this->url);
            $readability->debug                   = false;
            $readability->convertLinksToFootnotes = true;
            $result                               = $readability->init();
            if ($result) {
                $title   = $readability->getTitle()->textContent;
                $content = $readability->getContent()->innerHTML;
                if (function_exists('tidy_parse_string')) {
                    $tidy = tidy_parse_string($content, array('indent' => true, 'show-body-only' => true), 'UTF8');
                    $tidy->cleanRepair();
                    $content = $tidy->value;
                }
                if ($searchContent = trim(strip_tags($content))) {

                    $searchContent = preg_replace('/\n/', ' ', $searchContent);
                    $searchContent = preg_replace("/[^а-я ]/ui", "", $searchContent);
                    $searchContent = preg_replace('/\s+/', ' ', $searchContent);


                    $pn                 = new PendingNews();
                    $pn->source_id      = $this->source->id;
                    $pn->title          = $title;
                    $pn->content        = $content;
                    $pn->search_content = $searchContent;
                    $pn->status         = PendingNews::STATUS_NEW;
                    $pn->group_hash     = md5(time());
                    $pn->created_at     = new CDbExpression("NEW()");
                    if ($pn->save()) {
                        $this->parserQueue->status = ParserQueue::STATUS_DONE;
                        $this->parserQueue->save();
                    } else {
                        print_r($pn->getErrors());
                        $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                        $this->parserQueue->save();
                    }
                }
            } else {
                throw new Exception('Looks like we couldn\'t find the content. :(');
            }
        } else {
            $this->parserQueue->status = ParserQueue::STATUS_FAIL;
            $this->parserQueue->save();
        }
    }

    private function prepareUrl($link)
    {
        if (!strpos($link, "http")) {
            return $this->source->url . $link;
        }
    }
} 