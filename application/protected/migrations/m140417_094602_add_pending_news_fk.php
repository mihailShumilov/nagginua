<?php

class m140417_094602_add_pending_news_fk extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "ALTER TABLE `pending_news` ADD COLUMN `pq_id` INT(11) NULL  AFTER `source_id` ,
              ADD CONSTRAINT `fk_pending_news_2`
              FOREIGN KEY (`pq_id` )
              REFERENCES `parser_queue` (`id` )
              ON DELETE SET NULL
              ON UPDATE SET NULL
            , ADD INDEX `fk_pending_news_2_idx` (`pq_id` ASC) ;
            "
        );
    }

    public function down()
    {
        echo "m140417_094602_add_pending_news_fk does not support migration down.\n";
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