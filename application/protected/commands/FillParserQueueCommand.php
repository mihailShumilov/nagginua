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

                $parser = new NewsDetector($source);
                $parser->run();

            }

        }
    }
} 