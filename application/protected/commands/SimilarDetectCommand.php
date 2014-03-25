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
        $getUnprocessedNews = Yii::app()->db->createCommand(
            "SELECT * FROM " . PendingNews::model()->tableName(
            ) . " WHERE processed = 0 and status = 'pending' ORDER BY id ASC"
        );
        $dataReader         = $getUnprocessedNews->query();
        while (($row = $dataReader->read()) !== false) {
            if ($pn = PendingNews::model()->findByPk($row['id'])) {
                try {
                    $sd = new SimilarDetector($pn);
                    $sd->detect();
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n";
                }
            }

        }
    }
} 