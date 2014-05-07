<?php

class m140507_141209_add_fk_rss_sources extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "ALTER TABLE `rss_sources`
            CHANGE COLUMN `label` `source_id` INT(11) NOT NULL ,
            ADD INDEX `fk_rss_sources_1_idx` (`source_id` ASC);
            ALTER TABLE `news`.`rss_sources`
            ADD CONSTRAINT `fk_rss_sources_1`
              FOREIGN KEY (`source_id`)
              REFERENCES `sources` (`id`)
              ON DELETE NO ACTION
              ON UPDATE NO ACTION;
            "
        );
    }

    public function down()
    {
        echo "m140507_141209_add_fk_rss_sources does not support migration down.\n";
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