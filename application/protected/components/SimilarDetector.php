<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 25.03.14
 * Time: 11:54
 */
class SimilarDetector extends CApplicationComponent
{

    /**
     * @var PendingNews
     */
    private $news = false;

    public function __construct(PendingNews $pn)
    {
        $this->news = $pn;
    }

    public function detect()
    {
        if ($data = $this->searchByTitle()) {
            print_r($data);
        }
    }

    protected function  searchByTitle()
    {
        return $this->search($this->news->title);
    }

    protected function searchByContent()
    {
        return $this->search($this->news->search_content);
    }

    protected function search($content)
    {
        if ($content) {
            $sSql = 'SELECT * FROM search_content WHERE MATCH(' . Yii::app()->sphinx->quoteValue(
                    '' . $content . '/4'
                ) . ')
                OPTION ranker = expr(\'sum(exact_hit+10*(min_hit_pos==1)+lcs)*1000 +bm25\')';
            return Yii::app()->sphinx->createCommand($sSql)->queryAll();
        } else {
            return false;
        }
    }
} 