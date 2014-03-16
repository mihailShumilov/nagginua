<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 07.03.14
 * Time: 13:41
 */
class NewsDetector extends CApplicationComponent
{
    private $url;
    private $categoryPattern;
    private $newsPattern;
    private $sourceId;

    private $newsLinks = array();
    private $categoryLinks = array();

    public function __construct(Source $source)
    {
        $this->url             = $source->url;
        $this->categoryPattern = $source->category_pattern;
        $this->newsPattern     = $source->news_pattern;
        $this->sourceId        = $source->id;
    }

    public function run()
    {
        $firstPage = PageLoader::load($this->url);
        $this->detectNewsLinks($firstPage);
        $this->detectCategoryLinks($firstPage);
        $this->processCategoryLinks();
        $this->fillParserQueue();
    }

    private function detectCategoryLinks($content)
    {
        if ($content) {
            $this->categoryLinks = $this->linkDetector($content, $this->categoryPattern);
        } else {
            throw new Exception("No content data");
        }
    }

    private function detectNewsLinks($content)
    {
        if ($content) {
            $this->newsLinks = $this->linkDetector($content, $this->newsPattern);
        } else {
            throw new Exception("No content data");
        }
    }

    private function linkDetector($content, $pattern)
    {
        if ($content && $pattern) {
            $returnLink = array();
            preg_match_all('/href=\"([^\"]*)\"/i', $content, $results);
            if ($results[1]) {
                foreach ($results[1] as $link) {
                    $link = str_replace($this->url, '', $link);
                    if (preg_match("/^{$pattern}$/i", $link)) {
                        $returnLink[] = $link;
                    }
                }
                return $returnLink;
            }
        } else {
            throw new Exception("No content or pattern data");
        }
    }

    private function processCategoryLinks()
    {
        if (is_array($this->categoryLinks)) {
            $cnt = 0;
            foreach ($this->categoryLinks as $url) {
                $cnt++;
                if ($content = PageLoader::load($this->url . $url)) {
                    $this->detectNewsLinks($content);
                }
                $percentage = round($cnt / sizeof($this->categoryLinks) * 100, 2);
                echo "Completed:`{$percentage}%`\r";
            }
        }
    }

    private function fillParserQueue()
    {
        $this->newsLinks = array_unique($this->newsLinks);
        foreach ($this->newsLinks as $link) {
            try {
                $pqItem             = new ParserQueue();
                $pqItem->source_id  = $this->sourceId;
                $pqItem->url        = $link;
                $pqItem->status     = ParserQueue::STATUS_NEW;
                $pqItem->created_at = new CDbExpression('NOW()');
                if ($pqItem->save()) {

                } else {
                    print_r($pqItem->getErrors());
                }
            } catch (CDbException $e) {
                print_r($e->getMessage());
            }
        }
    }
} 