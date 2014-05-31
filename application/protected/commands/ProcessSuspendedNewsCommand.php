<?php

/**
 * Created by PhpStorm.
 * User: godson
 * Date: 08.03.14
 * Time: 23:43
 */
class ProcessSuspendedNewsCommand extends CConsoleCommand
{
    public function run($args)
    {
        echo "Start news parsing\n";
        $newsCount = PendingNews::model()->count("status=:status", array(":status" => PendingNews::STATUS_SUSPENDED));
        echo "News count: $newsCount\n";
        $counter = 0;
        $getLinksCommand = Yii::app()->db->createCommand(
            "SELECT * FROM pending_news WHERE status = '" . PendingNews::STATUS_SUSPENDED . "'"
        );
        $dataReader = $getLinksCommand->query();
        while (($row = $dataReader->read()) !== false) {
//        while (($row = Yii::app()->db->createCommand("SELECT * FROM pending_news WHERE status = '".PendingNews::STATUS_SUSPENDED."' LIMIT 1")->query(
//            )->read()) !== false) {
            print_r($row);
            if ($queueItem = ParserQueue::model()->findByPk($row['pq_id'])) {
                $counter++;
                try {
                    if (!LockNews::isLocked($row['id'])) {

                        if (LockNews::lock($row['id'])) {

                            $pn = PendingNews::model()->findByPk($row['id']);

                            $np = new NewsParser($queueItem, $pn);
                            if (!$np->run()) {
                                $pn->delete();
                            }

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

        }
        echo "\nNews parsing completed\n";
    }
}