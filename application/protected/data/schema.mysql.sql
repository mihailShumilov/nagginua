DELIMITER $$

# CREATE DATABASE `news` /*!40100 DEFAULT CHARACTER SET utf8 */$$

DELIMITER $$

CREATE TABLE `sources` (
  `id`               INT(11)      NOT NULL AUTO_INCREMENT,
  `label`            VARCHAR(255) NOT NULL,
  `url`              VARCHAR(255) NOT NULL,
  `category_pattern` VARCHAR(255) DEFAULT NULL,
  `news_pattern`     VARCHAR(255) DEFAULT NULL,
  `active`           TINYINT(4) DEFAULT '0',
  `created_at`       TIMESTAMP    NULL DEFAULT NULL,
  `updated_at`       TIMESTAMP    NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `active` (`active`)
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8$$

DELIMITER $$

CREATE TABLE `parser_queue` (
  `id`         INT(11)                                    NOT NULL AUTO_INCREMENT,
  `source_id`  INT(11)                                    NOT NULL,
  `url`        TEXT                                       NOT NULL,
  `status`     ENUM('new', 'in_progress', 'done', 'fail') NOT NULL DEFAULT 'new',
  `created_at` TIMESTAMP                                  NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP                                  NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `status_created` (`status`, `created_at`),
  KEY `fk_parser_queue_1_idx` (`source_id`),
  CONSTRAINT `fk_parser_queue_1` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8$$

DELIMITER $$

CREATE TABLE `pending_news` (
  `id`         INT(11)                                               NOT NULL AUTO_INCREMENT,
  `source_id`  INT(11)                                               NOT NULL,
  `title`      TEXT                                                  NOT NULL,
  `content`    LONGTEXT                                              NOT NULL,
  `status`     ENUM('pending', 'in_process', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
  `group_hash` VARCHAR(45)                                           NOT NULL,
  `created_at` TIMESTAMP                                             NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_at`  TIMESTAMP                                             NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `key_hash` (`group_hash`),
  KEY `status_created` (`status`, `created_at`),
  KEY `fk_pending_news_1_idx` (`source_id`),
  CONSTRAINT `fk_pending_news_1` FOREIGN KEY (`source_id`) REFERENCES `sources` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
  ENGINE =InnoDB
  DEFAULT CHARSET =utf8$$



