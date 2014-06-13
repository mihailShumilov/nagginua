<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 07.05.14
 * Time: 17:21
 */
class ParseNewsRssCommand extends CConsoleCommand
{
    public function run($args)
    {
        if ($sourceList = RssSources::model()->active()->is_full()->findAll()) {
            foreach ($sourceList as $source) {
                Yii::app()->getDb()->setActive(false);
                $pid = pcntl_fork();
                Yii::app()->getDb()->setActive(true);
                if (!$pid) {
                    $parser = new RssNewsParser($source);
                    $parser->run();
                    exit(0);
                }

            }

            while (pcntl_waitpid(0, $status) != -1) {
                $status = pcntl_wexitstatus($status);
                echo "Child $status completed\n";
            }
        }
    }
} 