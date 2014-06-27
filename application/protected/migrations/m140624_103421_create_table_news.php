<?php

class m140624_103421_create_table_news extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "CREATE TABLE `news` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `pending_news_id` INT NOT NULL,
              `title` TEXT NULL,
              `content` LONGTEXT NULL,
              `thumb` TEXT NULL,
              `status` ENUM('in_process','done','deleted') NULL DEFAULT 'in_process',
              `created_at` TIMESTAMP NULL,
              `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              UNIQUE INDEX `pending_news_id_UNIQUE` (`pending_news_id` ASC),
              INDEX `status_created` (`created_at` ASC, `status` ASC),
              CONSTRAINT `fk_news_1`
                FOREIGN KEY (`pending_news_id`)
                REFERENCES `pending_news` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);
            "
        );
    }

    public function down()
    {
        echo "m140624_103421_create_table_news does not support migration down.\n";
        return false;
    }

    /*
    // Use safeUp/safeDown to do migration with transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}