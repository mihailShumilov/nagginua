<?php

class m140519_092855_add_lock_table extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "CREATE TABLE `lock_news` (
              `id_news` INT NOT NULL,
              `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id_news`),
              CONSTRAINT `fk_lock_news_1`
                FOREIGN KEY (`id_news`)
                REFERENCES `pending_news` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);
            "
        );
    }

    public function down()
    {
        echo "m140519_092855_add_lock_table does not support migration down.\n";
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