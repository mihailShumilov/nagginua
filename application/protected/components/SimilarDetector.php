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
        if ($data = $this->searchByContent()) {
            $ids_to_update   = array();
//            $ids_to_update[] = $this->news->id;
            foreach ($data as $ids) {
                if ($ids['weight'] > 16000) {
                    $ids_to_update[] = $ids['id'];
                }
            }
            if ($ids_to_update) {
                sort($ids_to_update);
                $group_hash = $ids_to_update[0];

                foreach ($ids_to_update as $id) {
                    $pn = PendingNews::model()->findByPk($id);
                    if ($pn->group_hash != $group_hash) {
                        $pn->group_hash = $group_hash;
                        $pn->processed  = 1;
                        $pn->save();
                    }
                }
                $this->news->group_hash = $group_hash;
            } else {
                $this->news->group_hash = $this->news->id;
            }
        } else {
            $this->news->group_hash = $this->news->id;
        }
        $this->news->processed = 1;
        $this->news->save();
    }

    protected function  searchByTitle()
    {
        return $this->search($this->news->title);
    }

    public function searchByContent()
    {
        return $this->search($this->news->search_content);
    }

    protected function search($content)
    {
        if ($content) {
            $content = preg_replace('/\n/', ' ', $content);
            $content = preg_replace("/[^а-я ]/ui", "", $content);
            $content = preg_replace('/\s+/', ' ', $content);
            $content = Yii::app()->sphinx->quoteValue($content);
            $content = preg_replace("/^'/", "", $content);
            $content = preg_replace("/'$/", "", $content);
            $content = substr($content, 0, 1000);
            $sSql    = 'SELECT * FROM search_content WHERE MATCH(\'"' . $content . '"/4\')
                OPTION ranker = expr(\'sum(exact_hit+10*(min_hit_pos==1)+lcs)*1000 +bm25\')';
            return Yii::app()->sphinx->createCommand($sSql)->queryAll();
        } else {
            return false;
        }
    }
} 