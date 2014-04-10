<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 03.04.14
 * Time: 12:03
 */
class RtSearchTestCommand extends CConsoleCommand
{
    public function run($args)
    {
        if ($pn = PendingNews::model()->findByPk($args[0])) {
            $sd = new SimilarDetector($pn);
            print_r($sd->searchByTitleContent('pending_news_rt'));
        } else {
            echo "Pending news with id: `{$args[0]}` was not found\n";
        }
    }
} 