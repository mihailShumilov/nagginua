<?php

Yii::import('application.models._base.BasePendingNews');
Yii::import('application.extensions.DocumentHash');

class PendingNews extends BasePendingNews
{

    const STATUS_NEW = 'pending';
    const STATUS_INPROCESS = 'in_process';
    const STATUS_SUSPENDED = 'suspended';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'source' => array(self::BELONGS_TO, 'Source', 'source_id'),
            'pq' => array(self::BELONGS_TO, 'ParserQueue', 'pq_id'),
        );
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_at = new CDbExpression('NOW()');
                $this->update_at  = new CDbExpression('NOW()');
            } else {
                $this->update_at = new CDbExpression('NOW()');
            }
            return true;
        } else {
            return false;
        }
    }

    protected function afterSave()
    {
//        if ($this->isNewRecord) {
//            $sSql   = "INSERT INTO pending_news_rt VALUES({$this->id}, '{$this->id}', " . Yii::app()->sphinx->quoteValue(
//                $this->title
//            ) . ", " . Yii::app()->sphinx->quoteValue($this->search_content) . ")";
//        $result = Yii::app()->sphinx->createCommand($sSql)->execute();
//        }
//        return parent::afterSave();
    }

    public static function add(
        Source $source,
        $title,
        $content,
        $image_src,
        $status = PendingNews::STATUS_NEW,
        ParserQueue $parser_queue = null
    ) {


        if ($searchContent = trim(strip_tags($content))) {

            $searchContent = preg_replace('/\n/', ' ', $searchContent);
            $searchContent = preg_replace("/[^а-яa-z ]/ui", "", $searchContent);
            $searchContent = preg_replace('/\s+/', ' ', $searchContent);

            if (count(explode(" ", $searchContent)) >= Settings::get('news_min_length')) {

                $pn                 = new PendingNews();
                $pn->source_id      = $source->id;
                $pn->title          = $title;
                $pn->content        = $content;
                $pn->search_content = $searchContent;
                $pn->status         = $status;
                $pn->group_hash = md5(microtime());
                $pn->thumb_src      = $image_src;
                if ($parser_queue) {
                    $pn->pq_id = $parser_queue->id;
                }
                $pn->created_at = new CDbExpression("NEW()");
                if ($pn->save()) {
                    if ($parser_queue) {
                        $parser_queue->status = ParserQueue::STATUS_DONE;
                        $parser_queue->save();
                    }
                    PendingNews::fillSearchDB($searchContent, $pn->id);
                } else {
                    if ($parser_queue) {
                        $parser_queue->status = ParserQueue::STATUS_FAIL;
                        $parser_queue->save();
                    }
                }
            }
        }
    }

    public static function fillSearchDB($content, $newsID)
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
//                print_r($ih->getErrors());
//                die;
            }
        }

    }
}