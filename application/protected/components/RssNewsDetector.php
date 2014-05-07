<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 07.05.14
 * Time: 17:23
 */
class RssNewsDetector extends CApplicationComponent
{
    private $source;

    public function __construct(RssSources $source)
    {
        echo "Start parsing: {$source->source->label}\n";
        $this->source = $source;
    }

    public function run()
    {

        $patterns = SourcesSettings::getAll($this->source->source_id, 'rss_news_pattern');

        $rss                     = PageLoader::load($this->source->url);
        $doc                     = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        libxml_use_internal_errors(true);
        $doc->loadXML($rss);
        $xpath = new DOMXpath($doc);
        foreach ($patterns as $pattern) {

            if ($newsLinks = $xpath->query($pattern->value)) {
                for ($i = 0; $i < $newsLinks->length; $i++) {
                    $item = $newsLinks->item($i);
                    $url = str_replace($this->source->source->url, '', $item->nodeValue);
                    try {
                        $pqItem             = new ParserQueue();
                        $pqItem->source_id  = $this->source->source_id;
                        $pqItem->url = $url;
                        $pqItem->status     = ParserQueue::STATUS_NEW;
                        $pqItem->created_at = new CDbExpression('NOW()');
                        if ($pqItem->save()) {

                        } else {
                            print_r($pqItem->getErrors());
                        }
                    } catch (CDbException $e) {
//                print_r($e->getMessage());
                    }
                }
            }
        }
    }
} 