<?php

class m140624_055129_fix_lock extends CDbMigration
{
    public function up()
    {
        $this->execute(
            "UPDATE pending_news
                                        INNER JOIN lock_news ON lock_news.id_news  = pending_news.id
                                    SET
                                      pending_news.status = 'rejected'"
        );

        $this->execute("DELETE FROM lock_news");
    }

    public function down()
    {
        echo "m140624_055129_fix_lock does not support migration down.\n";
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