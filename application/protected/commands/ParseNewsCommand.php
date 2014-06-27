<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 08.03.14
 * Time: 23:43
 */
class ParseNewsCommand extends CConsoleCommand
{
    public function run($args)
    {
        echo "Start news parsing\n";
        $newsCount = ParserQueue::model()->count("status=:status", array(":status" => "new"));
        $counter   = 0;

        while (($row = Yii::app()->db->createCommand("SELECT * FROM parser_queue WHERE status = 'new' LIMIT 1")->query(
            )->read()) !== false) {
            if ($queueItem = ParserQueue::model()->findByPk($row['id'])) {
                $counter++;
                try {
                    if (!LockParserQueue::isLocked($queueItem->id)) {

                        if (LockParserQueue::lock($queueItem->id)) {
                            $np = new NewsParser($queueItem);
                            $np->run();
                            LockParserQueue::unLock($queueItem->id);
                        } else {
                            continue;
                        }
                    } else {
                        continue;
                    }
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n";
                }
                $percent = round($counter / $newsCount * 100, 2);
                echo "Completed {$percent}% ({$counter} of {$newsCount})\r";
//                break;
            }

        }
        echo "\nNews parsing completed\n";
    }
}