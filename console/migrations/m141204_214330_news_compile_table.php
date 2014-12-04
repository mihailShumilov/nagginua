<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m141204_214330_news_compile_table extends Migration
    {
        public function up()
        {
            $this->execute( "CREATE TABLE `npn` (
  `news_id` int(11) unsigned NOT NULL,
  `pending_news_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`news_id`,`pending_news_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );

        }

        public function down()
        {
            $this->dropTable( "npn" );
        }
    }
