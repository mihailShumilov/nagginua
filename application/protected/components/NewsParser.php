<?php
Yii::import('application.extensions.readability.Readability');
Yii::import('application.extensions.DocumentHash');

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
            $readability->convertLinksToFootnotes = false;
            $result                               = $readability->init();
            if ($result) {
                $title   = $readability->getTitle()->textContent;
                $title = $this->processTitleStopWords($title);
                $content = $readability->getContent()->innerHTML;
                $content = $this->processContentStopWords($content);
                $content = preg_replace('/\n/', ' ', $content);
                $content = strip_tags($content, "<p><div><img><span><br><ul><li>");
                $content = $this->fixUrls($content);
                if (function_exists('tidy_parse_string')) {
                    $tidy = tidy_parse_string($content, array('show-body-only' => true, 'wrap' => 0), 'UTF8');
                    $tidy->cleanRepair();
                    $content = $tidy->value;
                }
//                echo $content;
//                echo "\nURL: {$this->url}\n";
                if ($searchContent = trim(strip_tags($content))) {

                    $searchContent = preg_replace('/\n/', ' ', $searchContent);
                    $searchContent = preg_replace("/[^а-я ]/ui", "", $searchContent);
                    $searchContent = preg_replace('/\s+/', ' ', $searchContent);

                    if (count(explode(" ", $searchContent)) >= Settings::get('news_min_length')) {
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
                            $this->fillSearchDB($searchContent, $pn->id);
                        } else {
                            print_r($pn->getErrors());
                            $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                            $this->parserQueue->save();
                        }
                    } else {
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

    private function processContentStopWords($content)
    {
        foreach (ContentStopWords::model()->findAll("source_id = :si", array(":si" => $this->source->id)) as $csw) {
            if ($pos = strpos($content, $csw->word)) {
                $content = substr($content, 0, $pos);
            }
        }
        return $content;
    }

    private function processTitleStopWords($title)
    {
        foreach (TitleStopWords::model()->findAll("source_id = :si", array(":si" => $this->source->id)) as $csw) {
            if ($pos = strpos($title, $csw->word)) {
                $title = substr($title, 0, $pos);
            }
        }
        return $title;
    }

    private function fixUrls($content)
    {
        $content = preg_replace('/src=("(\/[^"]+)")/', "src=\"{$this->source->url}$2\"", $content);
        return $content;
    }

    private function fillSearchDB($content, $newsID)
    {
        $dh = new DocumentHash($content);

        $ihs            = new ItemsHashesSummary();
        $ihs->doc_id    = $newsID;
        $ihs->full_hash = $dh->docMD5;
        $tockens        = array_unique($dh->getCrc32array());
        $ihs->length    = sizeof($tockens);
        $ihs->save();

        foreach ($tockens as $token) {
            $ih            = new ItemsHashes();
            $ih->doc_id    = $newsID;
            $ih->word_hash = $token;
            if (!$ih->save()) {
                print_r($ih->getErrors());
                die;
            }
        }

    }
} 