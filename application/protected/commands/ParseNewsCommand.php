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
        $getLinksCommand = Yii::app()->db->createCommand("SELECT * FROM parser_queue WHERE status = 'new'");
        $dataReader      = $getLinksCommand->query();
        while (($row = $dataReader->read()) !== false) {
            if ($queueItem = ParserQueue::model()->findByPk($row['id'])) {
                try {
                    $np = new NewsParser($queueItem);
                    $np->run();
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n";
                }
            }

        }
    }
}