<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m141207_055014_add_tags_tables extends Migration
    {
        public function up()
        {

            $this->execute( "CREATE TABLE `tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `cnt` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );

            $this->execute( "CREATE TABLE `news_has_tags` (
  `news_id` int(11) NOT NULL,
  `tag_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`news_id`,`tag_id`),
  KEY `fk_tag` (`tag_id`),
  CONSTRAINT `fk_news` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );

        }

        public function down()
        {
            $this->dropTable( "news_has_tags" );
            $this->dropTable( "tags" );
        }
    }
