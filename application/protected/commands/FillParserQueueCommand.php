<?php
/**
 * Created by PhpStorm.
 * User: godson
 * Date: 07.03.14
 * Time: 13:50
 */
//Yii::import("application.models.Source");

class FillParserQueueCommand extends CConsoleCommand
{
    public function run($args)
    {
        if ($sourceList = Source::model()->active()->findAll()) {
            foreach ($sourceList as $source) {
                Yii::app()->getDb()->setActive(false);
                $pid = pcntl_fork();
                Yii::app()->getDb()->setActive(true);
                if (!$pid) {
                    $parser = new NewsDetector($source);
                    $parser->run();
                }

            }

            while (pcntl_waitpid(0, $status) != -1) {
                $status = pcntl_wexitstatus($status);
                echo "Child $status completed\n";
            }
        }
    }
} 