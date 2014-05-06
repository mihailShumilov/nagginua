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
            try {
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
                    $title   = $this->processTitleStopWords($title);
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

                    $content = $this->processExcludeElements($content);
                    if ($date = $this->processPublishDate($html)) {
                        if (!(date("Y-m-d") == date("Y-m-d", $date))) {
                            throw new CException("Old post");
                        }
                    }


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
                            $pn->thumb_src      = $this->detectThumb($html, $content);
                            $pn->pq_id          = $this->parserQueue->id;
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
            } catch (Exception $e) {
//                echo "\n";
//                print_r($e->getMessage());
//                echo "\n";

                $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                $this->parserQueue->save();
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

    private function fixUrl($url)
    {
        if ("/" == substr($url, 0, 1)) {
            $url = $this->source->url . $url;
        }
        return $url;
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

    private function detectThumb($html, $preparedHtml)
    {
        $thumbSrc = false;
        if ($this->source->thumb_pattern) {

            $doc                     = new DOMDocument();
            $doc->preserveWhiteSpace = false;
            libxml_use_internal_errors(true);
            $doc->loadHTML($html);
            $xpath = new DOMXpath($doc);
            if ($elements = $xpath->query($this->source->thumb_pattern)->item(0)) {
                $thumbSrc = $this->fixUrl($elements->attributes->getNamedItem('src')->nodeValue);
            }
        }

        if (!$thumbSrc) {
            if (preg_match_all('/(https?:\/\/[a-z0-9\/_а-я\-\.]*\.(?:png|jpg))/i', $preparedHtml, $images)) {
                $thumbSrc = $images[1][0];
            }
        }
        return $thumbSrc;
    }

    private function processExcludeElements($html)
    {
        if ($patterns = ExcludeElements::model()->findAll(
            "source_id = :source_id",
            array(":source_id" => $this->source->id)
        )
        ) {
            $htmlDoc = mb_convert_encoding($html, 'HTML-ENTITIES', "UTF-8");
            $doc     = new DOMDocument("1.0", "utf-8");
            $doc->preserveWhiteSpace = false;
            libxml_use_internal_errors(true);
            $doc->loadHTML($htmlDoc);
            $xpath = new DOMXpath($doc);

            foreach ($patterns as $pattern) {
                if ($element = $xpath->query($pattern->pattern)->item(0)) {
                    $replace = $doc->saveHTML($element);
                    $html    = str_replace($replace, '', $html);
                }

            }
        }
        return $html;
    }

    private function processPublishDate($html)
    {
        if ($patterns = SourcesSettings::getAll($this->source->id, 'date_pattern')) {
            $doc                     = new DOMDocument("1.0", "utf-8");
            $doc->preserveWhiteSpace = false;
            libxml_use_internal_errors(true);
            $doc->loadHTML($html);
            $xpath = new DOMXpath($doc);

            foreach ($patterns as $pattern) {

                if ($publishDate = $xpath->evaluate($pattern->value)) {
                    $publishDate = strtotime($publishDate);
                    return $publishDate;
                }
            }
        }
    }
} 