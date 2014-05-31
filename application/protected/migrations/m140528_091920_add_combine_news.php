<?php

class m140528_091920_add_combine_news extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "ALTER TABLE `rss_sources`
            ADD COLUMN `is_combine` TINYINT NULL DEFAULT 0 AFTER `is_full`;"
        );

        $this->execute(
            "ALTER TABLE `pending_news`
            CHANGE COLUMN `status` `status` ENUM('pending','in_process','approved','rejected','suspended') NOT NULL DEFAULT 'pending' ;
            "
        );


    }

    public function down()
    {
        echo "m140528_091920_add_combine_news does not support migration down.\n";
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