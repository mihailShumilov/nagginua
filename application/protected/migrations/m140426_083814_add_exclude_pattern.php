<?php

class m140426_083814_add_exclude_pattern extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "CREATE TABLE `exclude_elements` (
              `id` INT NOT NULL,
              `source_id` INT NOT NULL,
              `pattern` TEXT NOT NULL,
              PRIMARY KEY (`id`),
              INDEX `fk_exclude_elements_1_idx` (`source_id` ASC),
              CONSTRAINT `fk_exclude_elements_1`
                FOREIGN KEY (`source_id`)
                REFERENCES `sources` (`id`)
                ON DELETE CASCADE
                ON UPDATE CASCADE)
            "
        );
    }

    public function down()
    {
        echo "m140426_083814_add_exclude_pattern does not support migration down.\n";
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