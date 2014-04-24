<?php

class m140424_193448_added_thumb_path extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "ALTER TABLE `sources`
            ADD COLUMN `thumb_pattern` VARCHAR(255) NULL AFTER `news_pattern`;"
        );
        $this->execute(
            "ALTER TABLE `pending_news`
            ADD COLUMN `thumb_src` TEXT NULL AFTER `search_content`;"
        );
    }

    public function down()
    {
        echo "m140424_193448_added_thumb_path does not support migration down.\n";
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