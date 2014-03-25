<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 25.03.14
 * Time: 12:16
 */
class SimilarDetectCommand extends CConsoleCommand
{
    public function run($args)
    {
        $getLinksCommand = Yii::app()->db->createCommand(
            "SELECT * FROM " . PendingNews::model()->tableName() . " WHERE status = 'new'"
        );
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