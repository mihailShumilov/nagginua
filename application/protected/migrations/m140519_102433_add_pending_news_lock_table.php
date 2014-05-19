<?php

class m140519_102433_add_pending_news_lock_table extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "CREATE TABLE `lock_parser_queue` (
              `id_parser_queue` INT NOT NULL,
              `created_at` VARCHAR(45) NULL,
              PRIMARY KEY (`id_parser_queue`),
              CONSTRAINT `fk_lock_parser_queue_1`
                FOREIGN KEY (`id_parser_queue`)
                REFERENCES `parser_queue` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);
            "
        );
    }

    public function down()
    {
        echo "m140519_102433_add_pending_news_lock_table does not support migration down.\n";
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