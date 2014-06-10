<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 15.04.14
 * Time: 0:12
 */
class NaggPublisherCommand extends CConsoleCommand
{
    public function run($args)
    {
        echo "Start news publish to nagg.in.ua\n";
        $searchSql  = "SELECT id FROM pending_news WHERE processed = 1 AND status = 'approved' ORDER BY id ASC";
        $newsCount  = PendingNews::model()->countBySql(
            "SELECT count(id) FROM pending_news WHERE processed = 1 AND status = 'approved'"
        );
        $counter    = 0;
        $getNews    = Yii::app()->db->createCommand($searchSql);
        $dataReader = $getNews->query();
        while (($row = $dataReader->read()) !== false) {
            $counter++;
            if (!LockNews::isLocked($row['id'])) {

                if (LockNews::lock($row['id'])) {
                    if ($pn = PendingNews::model()->findByPk($row['id'])) {
                        $imageLink = false;
                        if ($pn->thumb_src) {
                            $imageLink = PageLoader::loadFile($pn->thumb_src);
                        }

                        $wp                                  = new Wordpress();
                        $customFields                        = array();
                        $customFields["pending_news_id"]     = $pn->id;
                        $customFields["pending_news_status"] = $pn->status;
                        if ($pn->source) {
                            $customFields["source"] = $pn->source->url;
                        }
                        if ($pn->pq) {
                            $customFields["url"]             = $pn->pq->url;
                            $customFields["parser_queue_id"] = $pn->pq_id;
                        }

                        if ($wp->createPost(
                            $pn->title,
                            $pn->content,
                            $customFields,
                            "publish",
                            $imageLink,
                            $this->detectCategories($pn->search_content),
                            KeywordDetector::detect($pn->search_content)
                        )
                        ) {
                            $pn->processed = 2;
                            $pn->save();
                        }

                        if ($imageLink) {
                            unlink($imageLink);
                        }
                    }
                    LockNews::unLock($row['id']);
                } else {
                    continue;
                }
            } else {
                continue;
            }
            $percent = round($counter / $newsCount * 100, 2);
            echo "Completed {$percent}% ({$counter} of {$newsCount})\r";
        }
        echo "End news publish to nagg.in.ua\n";
    }

    protected function detectCategories($content)
    {
        $content       = strtolower($content);
        $categorySlugs = array('all');
        foreach (Categories::model()->findAll() as $cat) {
            foreach (explode(",", $cat->keyword) as $word) {
                if (strpos($content, $word) > 0) {
                    $categorySlugs[] = $cat->slug;
                    break;
                }
            }
        }
        return $categorySlugs;
    }
} 