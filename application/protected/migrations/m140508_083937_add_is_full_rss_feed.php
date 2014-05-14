<?php

class m140508_083937_add_is_full_rss_feed extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "ALTER TABLE `rss_sources`
            ADD COLUMN `is_full` TINYINT NULL DEFAULT 0 AFTER `active`,
            ADD INDEX `index4` (`is_full` ASC, `active` ASC);
            "
        );
    }

    public function down()
    {
        echo "m140508_083937_add_is_full_rss_feed does not support migration down.\n";
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