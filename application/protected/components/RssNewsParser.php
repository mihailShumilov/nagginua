<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 09.05.14
 * Time: 15:20
 */
class RssNewsParser extends CApplicationComponent
{

    private $source;

    private $itemPatterns;

    private $titlePattern;

    private $contentPattern;

    private $linkPattern;

    private $imagePattern;

    public function __construct(RssSources $source)
    {
        echo "Start parsing: {$source->source->label}\n";
        $this->source         = $source;
        $this->itemPatterns   = SourcesSettings::getAll($this->source->source_id, 'rss_news_item_pattern');
        $this->titlePattern   = SourcesSettings::get($this->source->source_id, 'rss_title');
        $this->contentPattern = SourcesSettings::get($this->source->source_id, 'rss_content');
        $this->linkPattern    = SourcesSettings::get($this->source->source_id, 'rss_link');
        $this->imagePattern   = SourcesSettings::get($this->source->source_id, 'rss_image');
    }

    public function run()
    {
        $rss                     = PageLoader::load($this->source->url);
        $doc                     = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        libxml_use_internal_errors(true);
        $doc->loadXML($rss);
        $xpath = new DOMXpath($doc);
        foreach ($this->itemPatterns as $pattern) {

            if ($newsList = $xpath->query($pattern->value)) {
                for ($i = 0; $i < $newsList->length; $i++) {
                    $news                 = $newsList->item($i);
                    $newsParams           = array();
                    $newsParams['source'] = $this->source->source;
                    foreach ($news->childNodes as $node) {
                        if ($this->titlePattern == $node->nodeName) {
                            $newsParams['title'] = $node->nodeValue;
                        }
                        if ($this->contentPattern == $node->nodeName) {
                            $newsParams['content'] = $node->nodeValue;
                        }
                        if ($this->linkPattern == $node->nodeName) {
                            $newsParams['link'] = $node->nodeValue;
                        }
                        if ($this->imagePattern == $node->nodeName) {
                            if (preg_match_all(
                                '/(https?:\/\/[a-z0-9\/_а-я\-\.]*\.(?:png|jpg))/i',
                                $node->nodeValue,
                                $images
                            )
                            ) {
                                $newsParams['image_src'] = $images[1][0];
                            }
                        }
                        if (!isset($newsParams['image_src'])) {
                            if ($node->nodeName == 'enclosure') {
                                if (preg_match_all(
                                    '/(https?:\/\/[a-z0-9\/_а-я\-\.]*\.(?:png|jpg))/i',
                                    $node->getAttribute('url'),
                                    $images
                                )
                                ) {
                                    $newsParams['image_src'] = $images[1][0];
                                }
                            }
                        }
                    }

                    try {
                        $pqItem             = new ParserQueue();
                        $pqItem->source_id  = $this->source->source_id;
                        $pqItem->url        = $newsParams['link'];
                        $pqItem->status     = ParserQueue::STATUS_INPROCESS;
                        $pqItem->created_at = new CDbExpression('NOW()');
                        if ($pqItem->save()) {

                            PendingNews::add(
                                $newsParams['source'],
                                $newsParams['title'],
                                $newsParams['content'],
                                isset($newsParams['image_src']) ? $newsParams['image_src'] : false,
                                PendingNews::STATUS_NEW,
                                $pqItem
                            );
                        }
                    } catch (CDbException $e) {
                    }

                }
            }
        }
    }
} 