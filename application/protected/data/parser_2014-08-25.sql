DROP TABLE IF EXISTS `categories`;

CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `slug` varchar(45) NOT NULL,
  `keyword` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index2` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;

INSERT INTO `categories` (`id`, `name`, `slug`, `keyword`)
VALUES
	(2,'????','auto','??????????,??????,???????,?????,??????,???,???,??????,??????'),
	(3,'???????','ukraine','??????,????'),
	(4,'?????','sport','?????,??????,????,??????,?????????'),
	(5,'????????','politic','????????,???????,???????,?????,????,????????,??????,??????,???????,?????????'),
	(6,'?????????','economic','??????,??????,????,???????,????????,??????,????,??????,?????'),
	(7,'??????','donbass','???????,??????,???????,??????????,??????'),
	(8,'???????','kharkov','???????,??????,??????,????????,?????,???????????,???????????'),
	(9,'????','krim','????,???????????,?????,????'),
	(10,'????','kyiv','????');

/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `content_stop_words`;

CREATE TABLE `content_stop_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_content_stop_words_1_idx` (`source_id`),
  CONSTRAINT `fk_content_stop_words_1` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `content_stop_words` WRITE;
/*!40000 ALTER TABLE `content_stop_words` DISABLE KEYS */;

INSERT INTO `content_stop_words` (`id`, `source_id`, `word`)
VALUES
	(2,1,'??????? ?????'),
	(3,4,'?????????????? ?? ???????'),
	(4,1,'???? ?? ????? ?????? ? ??????,'),
	(5,1,'????????? ????????!'),
	(6,15,'???? ?? ???????? ??????'),
	(7,2,'??? ?? ??????? ?? ?????'),
	(8,23,'?????? ?? ????');

/*!40000 ALTER TABLE `content_stop_words` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `exclude_elements`;

CREATE TABLE `exclude_elements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) NOT NULL,
  `pattern` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_exclude_elements_1_idx` (`source_id`),
  CONSTRAINT `fk_exclude_elements_1` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `exclude_elements` WRITE;
/*!40000 ALTER TABLE `exclude_elements` DISABLE KEYS */;

INSERT INTO `exclude_elements` (`id`, `source_id`, `pattern`)
VALUES
	(1,1,'//*[@class=\'gallery_over\']'),
	(2,1,'//*[@itemprop=\'name\']'),
	(3,1,'//*[@itemprop=\'thumbnailUrl\']'),
	(4,1,'//*[@itemprop=\'image\']'),
	(5,1,'//*[@itemprop=\'datePublished\']'),
	(6,1,'//*[@itemprop=\'articleSection\']');

/*!40000 ALTER TABLE `exclude_elements` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `items_hashes`;

CREATE TABLE `items_hashes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `doc_id` int(11) NOT NULL,
  `word_hash` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `index2` (`word_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `items_hashes_summary`;

CREATE TABLE `items_hashes_summary` (
  `doc_id` int(11) NOT NULL,
  `full_hash` char(32) NOT NULL,
  `length` smallint(11) NOT NULL,
  PRIMARY KEY (`doc_id`),
  KEY `index2` (`full_hash`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `lock_news`;

CREATE TABLE `lock_news` (
  `id_news` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_news`),
  CONSTRAINT `fk_lock_news_1` FOREIGN KEY (`id_news`) REFERENCES `pending_news` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `lock_parser_queue`;

CREATE TABLE `lock_parser_queue` (
  `id_parser_queue` int(11) NOT NULL,
  `created_at` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_parser_queue`),
  CONSTRAINT `fk_lock_parser_queue_1` FOREIGN KEY (`id_parser_queue`) REFERENCES `parser_queue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `news`;

CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pending_news_id` int(11) NOT NULL,
  `title` text,
  `content` longtext,
  `thumb` text,
  `status` enum('in_process','done','deleted') DEFAULT 'in_process',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pending_news_id_UNIQUE` (`pending_news_id`),
  KEY `status_created` (`created_at`,`status`),
  CONSTRAINT `fk_news_1` FOREIGN KEY (`pending_news_id`) REFERENCES `pending_news` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `news_links`;

CREATE TABLE `news_links` (
  `id_news` int(11) NOT NULL,
  `id_pq` int(11) NOT NULL,
  PRIMARY KEY (`id_news`,`id_pq`),
  KEY `fk_news_links_2_idx` (`id_pq`),
  CONSTRAINT `fk_news_links_1` FOREIGN KEY (`id_news`) REFERENCES `news` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_news_links_2` FOREIGN KEY (`id_pq`) REFERENCES `parser_queue` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `parser_queue`;

CREATE TABLE `parser_queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) NOT NULL,
  `url` text NOT NULL,
  `status` enum('new','in_progress','done','fail') NOT NULL DEFAULT 'new',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `url_UNIQUE` (`url`(255)),
  KEY `status_created` (`status`,`created_at`),
  KEY `fk_parser_queue_1_idx` (`source_id`),
  CONSTRAINT `fk_parser_queue_1` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `pending_news`;

CREATE TABLE `pending_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) NOT NULL,
  `pq_id` int(11) DEFAULT NULL,
  `title` text NOT NULL,
  `content` longtext NOT NULL,
  `search_content` longtext NOT NULL,
  `thumb_src` text,
  `status` enum('pending','in_process','approved','rejected','suspended') NOT NULL DEFAULT 'pending',
  `group_hash` varchar(45) NOT NULL,
  `processed` tinyint(4) DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `key_hash` (`group_hash`),
  KEY `fk_pending_news_1_idx` (`source_id`),
  KEY `process` (`processed`),
  KEY `fk_pending_news_2_idx` (`pq_id`),
  KEY `status_created` (`status`,`processed`,`created_at`),
  CONSTRAINT `fk_pending_news_1` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pending_news_2` FOREIGN KEY (`pq_id`) REFERENCES `parser_queue` (`id`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `rss_sources`;

CREATE TABLE `rss_sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `active` tinyint(4) DEFAULT '0',
  `is_full` tinyint(4) DEFAULT '0',
  `is_combine` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `active` (`active`),
  KEY `fk_rss_sources_1_idx` (`source_id`),
  KEY `index4` (`is_full`,`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `rss_sources` WRITE;
/*!40000 ALTER TABLE `rss_sources` DISABLE KEYS */;

INSERT INTO `rss_sources` (`id`, `source_id`, `url`, `active`, `is_full`, `is_combine`, `created_at`, `updated_at`)
VALUES
	(1,2,'http://k.img.com.ua/rss/ru/all_news2.0.xml',1,1,0,'2014-05-07 16:55:27','2014-05-07 16:55:27'),
	(2,1,'http://www.segodnya.ua/xml/rss.html',1,0,1,'2014-05-12 11:36:02','2014-05-12 11:36:02'),
	(3,4,'http://news.liga.net/all/rss.xml',1,0,1,'2014-05-12 12:40:22','2014-05-12 12:40:22'),
	(4,5,'http://gazeta.ua/ru/rss',1,1,0,'2014-05-14 12:48:44','2014-05-14 12:48:44'),
	(5,3,'http://fr.ill.in.ua/rss/ru/all.xml',1,1,0,'2014-05-19 11:02:11','2014-05-19 11:02:11'),
	(6,6,'http://glavcom.ua/rss.xml',1,1,0,'2014-05-20 06:54:19','2014-05-20 06:54:19'),
	(7,7,'http://interfax.com.ua/news/last.rss',1,1,0,'2014-05-20 13:43:14','2014-05-20 13:43:14'),
	(8,9,'http://ipress.ua/ru/rss/export.rss',1,0,1,NULL,NULL),
	(9,10,'http://www.unn.com.ua/rss/news_ru.xml',1,0,1,NULL,NULL),
	(10,11,'http://obozrevatel.com/rss.xml',1,0,1,NULL,NULL),
	(11,12,'http://feeds.feedburner.com/economic-ua/?format=xml',1,0,1,NULL,NULL),
	(12,14,'http://www.objectiv.tv/misc/rss/objective.xml',1,0,1,NULL,NULL),
	(13,15,'http://www.057.ua/rss',1,0,1,NULL,NULL),
	(14,17,'http://www.0642.ua/rss',1,1,0,NULL,NULL),
	(15,18,'http://www.62.ua/rss',1,1,0,NULL,NULL),
	(16,19,'http://www.048.ua/rss',1,1,0,NULL,NULL),
	(17,20,'http://www.056.ua/rss',1,1,0,NULL,NULL),
	(18,21,'http://www.061.ua/rss',1,1,0,NULL,NULL),
	(19,22,'http://www.0629.com.ua/rss',1,1,0,NULL,NULL),
	(20,23,'http://rian.com.ua/export/rss2/ukraine_news/index.xml',1,0,1,NULL,NULL);

/*!40000 ALTER TABLE `rss_sources` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;

INSERT INTO `settings` (`name`, `value`)
VALUES
	('news_min_length','30'),
	('similar_weight','50');

/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `sources`;

CREATE TABLE `sources` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `category_pattern` varchar(255) DEFAULT NULL,
  `news_pattern` varchar(255) DEFAULT NULL,
  `thumb_pattern` varchar(255) DEFAULT NULL,
  `active` tinyint(4) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `sources` WRITE;
/*!40000 ALTER TABLE `sources` DISABLE KEYS */;

INSERT INTO `sources` (`id`, `label`, `url`, `category_pattern`, `news_pattern`, `thumb_pattern`, `active`, `created_at`, `updated_at`)
VALUES
	(1,'segodnya.ua','http://www.segodnya.ua','\\/.*\\.html','\\/.*\\/.*\\.html',NULL,0,'0000-00-00 00:00:00','2014-03-07 13:49:00'),
	(2,'korrespondent.net','http://korrespondent.net','\\/.*\\/','\\/.*\\/[0-9]+-[0-9a-z\\-_]+','//*[@class=\'post-item__photo-img\']',0,'2014-04-25 14:10:13','2014-03-27 01:27:55'),
	(3,'forbes.ua','http://forbes.ua','\\/.*\\/','\\/.*\\/[0-9]+-[0-9a-z\\-_]+','//*[@class=\'post-item__photo-img\']',0,'2014-03-29 06:55:29','2014-03-27 01:27:55'),
	(4,'news.liga.net','http://news.liga.net','\\/all\\/.*\\/','\\/.*\\/.*\\/[0-9]+-[0-9a-z\\-_]+\\.htm','//*[@id=\'material-image\']',0,'2014-03-31 09:13:06','2014-03-31 09:13:06'),
	(5,'gazeta.ua','http://gazeta.ua',NULL,NULL,NULL,0,'2014-05-14 12:47:37','2014-05-14 12:47:37'),
	(6,'glavcom.ua','http://glavcom.ua/',NULL,NULL,NULL,0,'2014-05-20 06:49:44','2014-05-20 06:49:44'),
	(7,'interfax.com.ua','http://interfax.com.ua',NULL,NULL,NULL,0,'2014-05-20 13:39:51','2014-05-20 13:39:51'),
	(8,'news.bigmir.net','http://news.bigmir.net',NULL,NULL,NULL,0,NULL,NULL),
	(9,'ipress.ua','http://ipress.ua',NULL,NULL,'//*[@class=\'nimages\']/img',0,NULL,NULL),
	(10,'unn.com.ua','http://www.unn.com.ua',NULL,NULL,'//*[@class=\'b-news-full-img\']/img',0,NULL,NULL),
	(11,'obozrevatel.com','http://obozrevatel.com/',NULL,NULL,NULL,0,NULL,NULL),
	(12,'en-ua.com','http://en-ua.com/',NULL,NULL,'//*[@class=\'img-thumb\']/img',0,NULL,NULL),
	(13,'sprotyv.info','http://sprotyv.info/',NULL,NULL,NULL,0,NULL,NULL),
	(14,'objectiv.tv','http://www.objectiv.tv/',NULL,NULL,NULL,0,NULL,NULL),
	(15,'057.ua','http://www.057.ua/',NULL,NULL,'//*[@class=\'img-block\']/img',0,NULL,NULL),
	(16,'sport.ua','http://sport.ua',NULL,NULL,NULL,0,NULL,NULL),
	(17,'0642.ua','http://www.0642.ua',NULL,NULL,NULL,0,NULL,NULL),
	(18,'62.ua','http://www.62.ua/',NULL,NULL,NULL,0,NULL,NULL),
	(19,'048.ua','http://www.048.ua/',NULL,NULL,NULL,0,NULL,NULL),
	(20,'056.ua','http://www.056.ua/',NULL,NULL,NULL,0,NULL,NULL),
	(21,'061.ua','http://www.061.ua/',NULL,NULL,NULL,0,NULL,NULL),
	(22,'0629.com.ua','http://www.0629.com.ua/',NULL,NULL,NULL,0,NULL,NULL),
	(23,'rian.com.ua','http://rian.com.ua',NULL,NULL,NULL,0,NULL,NULL);

/*!40000 ALTER TABLE `sources` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `sources_settings`;

CREATE TABLE `sources_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`id`),
  KEY `source_name` (`source_id`,`name`),
  CONSTRAINT `fk_sources_settings_1` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `sources_settings` WRITE;
/*!40000 ALTER TABLE `sources_settings` DISABLE KEYS */;

INSERT INTO `sources_settings` (`id`, `source_id`, `name`, `value`)
VALUES
	(1,1,'date_pattern','string(//*[@http-equiv=\'last-modified\']/@content)'),
	(2,1,'date_pattern','string(//*[@http-equiv=\'LAST-Modified\']/@content)'),
	(3,1,'date_pattern','string(/html/body/div[4]/div/div[4]/div/div/div/table/tbody/tr/td)'),
	(4,4,'date_pattern','string(//*[@property=\'article:published_time\']/@content)'),
	(5,4,'date_pattern','string(//*[@property=\'article:modified_time\']/@content)'),
	(6,4,'date_pattern','string(/html/body/div[5]/div[4]/div/div/div/div)'),
	(7,2,'rss_news_pattern','//item/link'),
	(8,1,'rss_news_pattern','//item/link'),
	(9,4,'rss_news_pattern','//item/link'),
	(10,2,'rss_news_item_pattern','//item'),
	(11,2,'rss_title','title'),
	(12,2,'rss_content','fulltext'),
	(13,2,'rss_link','link'),
	(14,2,'rss_image','image'),
	(15,5,'rss_news_item_pattern','//item'),
	(16,5,'rss_title','title'),
	(17,5,'rss_content','description'),
	(18,5,'rss_link','link'),
	(19,5,'rss_image','enclosure'),
	(20,3,'rss_news_item_pattern','//item'),
	(21,3,'rss_title','title'),
	(22,3,'rss_content','fulltext'),
	(23,3,'rss_link','link'),
	(24,3,'rss_image','image'),
	(25,6,'rss_news_item_pattern','//item'),
	(26,6,'rss_title','title'),
	(27,6,'rss_content','fulltext'),
	(28,6,'rss_link','link'),
	(29,6,'rss_image','enclosure'),
	(30,7,'rss_news_item_pattern','//item'),
	(31,7,'rss_title','title'),
	(32,7,'rss_link','link'),
	(33,7,'rss_content','yandex:full-text'),
	(34,7,'rss_image','enclosure'),
	(35,1,'rss_news_item_pattern','//item'),
	(36,1,'rss_title','title'),
	(37,1,'rss_link','link'),
	(38,1,'rss_image','enclosure'),
	(39,4,'rss_news_item_pattern','//item'),
	(40,4,'rss_title','title'),
	(41,4,'rss_link','link'),
	(42,4,'rss_image','enclosure'),
	(43,9,'rss_news_item_pattern','//item'),
	(44,9,'rss_title','title'),
	(45,9,'rss_link','link'),
	(46,10,'rss_news_item_pattern ','//item'),
	(47,10,'rss_link','link'),
	(48,10,'rss_title','title'),
	(49,11,'rss_news_item_pattern','//item'),
	(50,11,'rss_link','link'),
	(51,11,'rss_title','title'),
	(52,11,'rss_image','enclosure '),
	(53,12,'rss_news_item_pattern','//item'),
	(54,12,'rss_link','link'),
	(55,12,'rss_title','title'),
	(56,14,'rss_news_item_pattern ','//item'),
	(57,14,'rss_link','link'),
	(58,14,'rss_title','title'),
	(59,14,'rss_image','enclosure'),
	(60,15,'rss_news_item_pattern ','//item'),
	(61,15,'rss_title','title'),
	(62,15,'rss_link','link'),
	(63,15,'rss_content ','content:encoded'),
	(64,17,'rss_news_item_pattern','//item'),
	(65,17,'rss_link','link'),
	(66,17,'rss_title','title'),
	(67,17,'rss_content','content:encoded'),
	(68,17,'rss_image','enclosure'),
	(69,18,'rss_news_item_pattern','//item'),
	(70,18,'rss_link','link'),
	(71,18,'rss_title','title'),
	(72,18,'rss_content','content:encoded'),
	(73,18,'rss_image','enclosure'),
	(74,19,'rss_news_item_pattern','//item'),
	(75,19,'rss_link','link'),
	(76,19,'rss_title','title'),
	(77,19,'rss_content','content:encoded'),
	(78,19,'rss_image','enclosure'),
	(79,20,'rss_news_item_pattern','//item'),
	(80,20,'rss_link','link'),
	(81,20,'rss_title','title'),
	(82,20,'rss_content','content:encoded'),
	(83,20,'rss_image','enclosure'),
	(84,21,'rss_news_item_pattern','//item'),
	(85,21,'rss_title','title'),
	(86,21,'rss_link','link'),
	(87,21,'rss_content','content:encoded'),
	(88,21,'rss_image','enclosure'),
	(89,22,'rss_news_item_pattern','//item'),
	(90,22,'rss_link','link'),
	(91,22,'rss_title','title'),
	(92,22,'rss_content','content:encoded'),
	(93,22,'rss_image','enclosure'),
	(94,23,'rss_news_item_pattern','//item'),
	(95,23,'rss_title','title'),
	(96,23,'rss_link','link'),
	(97,23,'rss_image','enclosure');

/*!40000 ALTER TABLE `sources_settings` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `tbl_migration`;

CREATE TABLE `tbl_migration` (
  `version` varchar(255) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tbl_migration` WRITE;
/*!40000 ALTER TABLE `tbl_migration` DISABLE KEYS */;

INSERT INTO `tbl_migration` (`version`, `apply_time`)
VALUES
	('m000000_000000_base',1398086379),
	('m140417_094602_add_pending_news_fk',1398086489),
	('m140424_193448_added_thumb_path',1398411917),
	('m140426_083814_add_exclude_pattern',1399107446),
	('m140503_083410_add_autoincrement_to_exclude_elements',1399107446),
	('m140504_044642_add_source_settings',1399386515),
	('m140507_133703_add_rss_sources',1399474445),
	('m140507_141209_add_fk_rss_sources',1399474446),
	('m140508_083937_add_is_full_rss_feed',1400062408),
	('m140519_092855_add_lock_table',1400559387),
	('m140519_102433_add_pending_news_lock_table',1400559387),
	('m140528_091920_add_combine_news',1401532760),
	('m140624_055129_fix_lock',1403589617),
	('m140624_103421_create_table_news',1403844480),
	('m140624_105955_add_news_links',1403844480);

/*!40000 ALTER TABLE `tbl_migration` ENABLE KEYS */;
UNLOCK TABLES;


DROP TABLE IF EXISTS `title_stop_words`;

CREATE TABLE `title_stop_words` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source_id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_title_stop_words_1_idx` (`source_id`),
  CONSTRAINT `fk_title_stop_words_1` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `title_stop_words` WRITE;
/*!40000 ALTER TABLE `title_stop_words` DISABLE KEYS */;

INSERT INTO `title_stop_words` (`id`, `source_id`, `word`)
VALUES
	(3,1,'|'),
	(4,2,'- Korrespondent.net'),
	(5,2,'Korrespondent.net'),
	(6,1,'??????? ??????? ???????'),
	(7,1,'??????? ???????'),
	(8,9,', iPress.ua'),
	(9,9,' iPress.ua'),
	(10,9,','),
	(11,10,'?????????????? ?????????');

/*!40000 ALTER TABLE `title_stop_words` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
