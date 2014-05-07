<?php

class m140507_133703_add_rss_sources extends CDbMigration
{
    public function up()
    {
        $this->execute(
            'CREATE TABLE `rss_sources` (
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `label` varchar(255) NOT NULL,
              `url` varchar(255) NOT NULL,
              `active` tinyint(4) DEFAULT \'0\',
              `created_at` timestamp NULL DEFAULT NULL,
              `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
              PRIMARY KEY (`id`),
              KEY `active` (`active`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;'
        );
    }

    public function down()
    {
        echo "m140507_133703_add_rss_sources does not support migration down.\n";
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