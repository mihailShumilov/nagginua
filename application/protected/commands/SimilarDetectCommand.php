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
        echo "Start similar detecting\n";

        $newsCount = PendingNews::model()->count(
            "processed = :processed and status = :status",
            array(":processed" => 0, ":status" => "pending")
        );
        $counter   = 0;

        $getUnprocessedNews = Yii::app()->db->createCommand(
            "SELECT * FROM " . PendingNews::model()->tableName(
            ) . " WHERE processed = 0 and status = 'pending' ORDER BY id ASC"
        );
        $dataReader         = $getUnprocessedNews->query();
        while (($row = $dataReader->read()) !== false) {
            if ($pn = PendingNews::model()->findByPk($row['id'])) {
                $counter++;
                try {
                    $sd = new SimilarDetector($pn);
                    $sd->detect();
                } catch (Exception $e) {
                    echo $e->getMessage() . "\n";
                }
                $percent = round($counter / $newsCount * 100, 2);
                echo "Completed {$percent}% ({$counter} of {$newsCount})\r";
            }

        }
        echo "Finish similar detecting\n";
    }
} 