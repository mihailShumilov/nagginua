<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 24.06.14
 * Time: 13:40
 */
class NewsComposer extends CApplicationComponent
{
    /**
     * @var PendingNews $pendingNews
     */
    private $pendingNews;
    private $dependedNews;

    public function __construct($pending_news_id)
    {
        if ($pending_news_id) {
            if ($this->pendingNews = PendingNews::model()->findByPk($pending_news_id)) {
                $this->findDependedNews();
                $this->compose();
            } else {
                throw new CException(Yii::t(
                    'News composer',
                    'Pending news with ID {pending_news_id} was not found',
                    array('{pending_news_id}' => $pending_news_id)
                ));
            }
        } else {
            throw new CException(Yii::t('News composer', 'Pending news ID not set'));
        }
    }

    private function findDependedNews()
    {
        $this->dependedNews = PendingNews::model()->findAll(
            "group_hash = :group_hash and status = :status",
            array(":group_hash" => $this->pendingNews->id, ":status" => PendingNews::STATUS_REJECTED)
        );
    }

    private function compose()
    {
        $news                  = new News();
        $news->pending_news_id = $this->pendingNews->id;
        $news->title           = $this->pendingNews->title;
        $news->content         = $this->pendingNews->content;
        $news->thumb           = $this->pendingNews->thumb_src;
        if (!$news->thumb) {
            if ($this->dependedNews) {
                foreach ($this->dependedNews as $dNews) {
                    if ($dNews->thumb_src) {
                        $news->thumb = $dNews->thumb_src;
                        break;
                    }
                }
            }
        }
        if ($news->save()) {
            if ($this->dependedNews) {
                foreach ($this->dependedNews as $dNews) {
                    $newsLink          = new NewsLinks();
                    $newsLink->id_news = $news->id;
                    $newsLink->id_pq   = $dNews->pq_id;
                }
            }
        }
        $news->status = 'done';
        $news->save();
    }
} 