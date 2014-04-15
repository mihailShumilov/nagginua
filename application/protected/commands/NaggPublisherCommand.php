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
            if ($pn = PendingNews::model()->findByPk($row['id'])) {
                $imageLink = false;
                if (preg_match_all('/(https?:\/\/[a-z0-9\/_а-я\-\.]*\.(?:png|jpg))/i', $pn->content, $images)) {
                    $imageLink = PageLoader::loadFile($images[1][0]);
                }

                $wp = new Wordpress();
                if ($wp->createPost(
                    $pn->title,
                    $pn->content,
                    $pn->source->url,
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