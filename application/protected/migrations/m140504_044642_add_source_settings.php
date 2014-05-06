<?php

class m140504_044642_add_source_settings extends CDbMigration
{
    public function up()
    {
        $this->execute(
            'CREATE TABLE `sources_settings` (
              `id` INT NOT NULL AUTO_INCREMENT,
              `source_id` INT NOT NULL,
              `name` VARCHAR(255) NOT NULL,
              `value` TEXT NULL,
              PRIMARY KEY (`id`),
              INDEX `source_name` (`source_id` ASC, `name` ASC),
              CONSTRAINT `fk_sources_settings_1`
                FOREIGN KEY (`source_id`)
                REFERENCES `sources` (`id`)
                ON DELETE NO ACTION
                ON UPDATE NO ACTION);
            '
        );
    }

    public function down()
    {
        echo "m140504_044642_add_source_settings does not support migration down.\n";
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