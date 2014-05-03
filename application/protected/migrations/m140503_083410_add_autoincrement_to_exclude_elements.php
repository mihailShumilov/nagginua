<?php

class m140503_083410_add_autoincrement_to_exclude_elements extends CDbMigration
{
    public function up()
    {
        $this->execute(
            'ALTER TABLE `exclude_elements`
            CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;'
        );
    }

    public function down()
    {
        echo "m140503_083410_add_autoincrement_to_exclude_elements does not support migration down.\n";
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