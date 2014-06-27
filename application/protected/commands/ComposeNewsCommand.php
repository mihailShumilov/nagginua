<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 24.06.14
 * Time: 14:46
 */
class ComposeNewsCommand extends CConsoleCommand
{
    public function run($args)
    {
        echo "Start news composing\n";
        $newsCount = PendingNews::model()->count(
            "status=:status and processed = :processed",
            array(":status" => "approved", ":processed" => 2)
        );
        $counter   = 0;

        while (($row = Yii::app()->db->createCommand(
                "SELECT * FROM pending_news WHERE status = 'approved' and processed = 2 ORDER BY id DESC LIMIT 1"
            )->query()->read()) !== false) {
            $counter++;
            try {
                if (!LockNews::isLocked($row['id'])) {

                    if (LockNews::lock($row['id'])) {
                        $nc = new NewsComposer($row['id']);
                        PendingNews::model()->updateByPk($row['id'], array("processed" => "2"));
                        LockNews::unLock($row['id']);
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
        echo "\nNews parsing completed\n";
    }
}