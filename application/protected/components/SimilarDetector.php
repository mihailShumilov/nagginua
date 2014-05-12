<?php

Yii::import('application.extensions.DocumentHash');


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
            $ids_to_update = array();
//            $ids_to_update[] = $this->news->id;
            foreach ($data as $ids) {
                if ($ids['weight'] > Settings::get('similar_weight')) {
                    $ids_to_update[] = $ids['id'];
                }
            }
            if ($ids_to_update) {
                sort($ids_to_update);

                //check to existing accepted or rejected news
                $getOneNews = Yii::app()->db->createCommand(
                    "SELECT id, status
                    FROM pending_news
                    WHERE id IN (" . implode(",", $ids_to_update) . ") AND status in ('approved','rejected')"
                );

                $dr          = $getOneNews->query();
                $run         = true;
                $rejectedIds = array();
                while (($result = $dr->read()) !== false) {
                    $run = false;
                    if (!in_array($result['status'], array('approved', 'rejected'))) {
                        $rejectedIds[] = $result['id'];
//                        if($pn = PendingNews::model()->findByPk($result['id'])){
//                            $pn->status = 'rejected';
//                            $pn->processed  = 1;
//                            $pn->save();
//                        }
                    }
                }
                if (!$run) {
                    $rejectedIds[] = $this->news->id;
                }
                if ($rejectedIds) {
                    PendingNews::model()->updateAll(
                        array("status" => "rejected", "processed" => 1),
                        "id IN(" . implode(",", $rejectedIds) . ")"
                    );
                }

                if ($run) {

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
                }
            } else {
                $this->news->group_hash = $this->news->id;
            }
        } else {
            $this->news->group_hash = $this->news->id;
        }
        $this->news->refresh();
        $this->news->processed = 1;
        $this->news->save();
    }

    protected function  searchByTitle()
    {
        return $this->search($this->news->title);
    }

    public function searchByContent($index_name = 'search_content')
    {
        return $this->search($this->news->search_content, $index_name);
    }

    public function searchByTitleContent($index_name = 'search_content')
    {
        return $this->search($this->news->title . ", " . $this->news->search_content, $index_name);
    }

    protected function search($content, $index_name = 'search_content')
    {
        if ($content) {
            $returnIds = array();
            $dh        = new DocumentHash($content);
            if ($results = ItemsHashesSummary::model()->findAll(
                "full_hash = :full_hash AND length = :length",
                array(":full_hash" => $dh->docMD5, ":length" => $dh->length)
            )
            ) {
                foreach ($results as $ihs) {
                    $returnIds[] = array('id' => $ihs->doc_id, 'weight' => 100);
                }
            }
            $hashClause = "0";
            foreach ($dh->getCrc32array() as $token_hash) {
                $hashClause .= " OR word_hash=$token_hash";
            }

            $findCmd = Yii::app()->db->createCommand(
                "SELECT doc_id, COUNT(id) as inters FROM items_hashes WHERE 1 AND ($hashClause) GROUP BY doc_id HAVING inters>1"
            );

            $dataReader = $findCmd->query();
            while (($row = $dataReader->read()) !== false) {

                $result2     = ItemsHashesSummary::model()->findByPk($row['doc_id']);
                $length      = $result2->length;
                $length      = min($length, $dh->length);
                $weight      = ($row['inters'] / $length) * 100;
                $returnIds[] = array('id' => $row['doc_id'], 'weight' => $weight);
            }

            return $returnIds;
//            $content = preg_replace('/\n/', ' ', $content);
//            $content = preg_replace("/[^а-я ]/ui", "", $content);
//            $content = preg_replace('/\s+/', ' ', $content);
//            $content = Yii::app()->sphinx->quoteValue($content);
//            $content = preg_replace("/^'/", "", $content);
//            $content = preg_replace("/'$/", "", $content);
//            $content = substr($content, 0, 1000);
//            $sSql = 'SELECT * FROM ' . $index_name . ' WHERE MATCH(\'"' . $content . '"/4\')
//                OPTION ranker = expr(\'sum(exact_hit+10*(min_hit_pos==1)+lcs)*1000 +bm25\')';
//            return Yii::app()->sphinx->createCommand($sSql)->queryAll();


        } else {
            return false;
        }
    }
} 