<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m141228_214940_add_tables extends Migration
    {
        public function up()
        {
            $this->execute( "SET FOREIGN_KEY_CHECKS=0;" );
            $this->dropTable( 'categories' );
            $this->execute( "SET FOREIGN_KEY_CHECKS=1;" );
            $this->execute( "CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index2` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
            $this->execute( "INSERT INTO `categories` (`id`, `name`, `slug`)
VALUES
	(11,'Все новости','all'),
	(12,'АТО','ato'),
	(13,'Экономика','economic'),
	(14,'Политика','politics'),
	(17,'Спорт','sport');" );
            $this->execute( "CREATE TABLE `category_words` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `category_words_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );
            $this->execute( "INSERT INTO `category_words` (`id`, `category_id`, `word`)
VALUES
	(1,12,'ато'),
	(2,12,'нацгвардия'),
	(3,12,'новороссия'),
	(4,12,'армия'),
	(5,12,'груз 200'),
	(6,12,'айдар'),
	(7,12,'конвой'),
	(8,12,'террористы'),
	(9,12,'лнр'),
	(10,12,'днр'),
	(11,13,'гривна'),
	(12,13,'доллар'),
	(13,13,'экономика'),
	(14,13,'рубль'),
	(15,13,'евро'),
	(16,13,'нефть'),
	(17,13,'банк'),
	(18,13,'торги'),
	(19,13,'межбанк'),
	(20,17,'футбол'),
	(21,17,'бокс'),
	(22,17,'воллейбол'),
	(23,17,'баскетбол'),
	(24,17,'гандбол'),
	(25,17,'тенис'),
	(26,14,'верховная рада'),
	(27,14,'выборы'),
	(28,14,'партия'),
	(29,14,'горсовет'),
	(30,14,'мандат');" );
            $this->execute( "CREATE TABLE `news_has_category` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `news_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_id` (`category_id`,`news_id`),
  KEY `news_id` (`news_id`),
  CONSTRAINT `news_has_category_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `news_has_category_ibfk_2` FOREIGN KEY (`news_id`) REFERENCES `news` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;" );

        }

        public function down()
        {
            echo "m141228_214940_add_tables cannot be reverted.\n";

            return false;
        }
    }
