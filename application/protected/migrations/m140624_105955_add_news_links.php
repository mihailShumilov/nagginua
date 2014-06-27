<?php

class m140624_105955_add_news_links extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "CREATE TABLE `news_links` (
              `id_news` INT NOT NULL,
              `id_pq` INT NOT NULL,
              PRIMARY KEY (`id_news`, `id_pq`),
              INDEX `fk_news_links_2_idx` (`id_pq` ASC),
              CONSTRAINT `fk_news_links_1`
                FOREIGN KEY (`id_news`)
                REFERENCES `news` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION,
              CONSTRAINT `fk_news_links_2`
                FOREIGN KEY (`id_pq`)
                REFERENCES `parser_queue` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);
            "
        );
    }

    public function down()
    {
        echo "m140624_105955_add_news_links does not support migration down.\n";
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