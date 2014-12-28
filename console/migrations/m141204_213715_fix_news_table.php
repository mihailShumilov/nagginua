<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m141204_213715_fix_news_table extends Migration
    {
        public function up()
        {
            $this->execute( "SET FOREIGN_KEY_CHECKS=0;" );
            $this->dropTable( "news" );
            $this->execute( "CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
    `title` text CHARACTER SET utf8mb4,
  `thumb` text CHARACTER SET utf8mb4,
  `status` enum('in_process','done','deleted') CHARACTER SET utf8mb4 DEFAULT 'in_process',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `status_created` (`created_at`,`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
            $this->execute( "SET FOREIGN_KEY_CHECKS=1;" );

        }

        public function down()
        {
            echo "m141204_213715_fix_news_table cannot be reverted.\n";

            return false;
        }
    }
