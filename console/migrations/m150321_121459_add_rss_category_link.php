<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150321_121459_add_rss_category_link extends Migration
    {
        public function up()
        {
            $this->execute( "ALTER TABLE rss_sources
          ADD COLUMN category_id integer;" );
        }

        public function down()
        {
            $this->dropColumn( 'rss_sources', 'category_id' );
        }

        /*
        // Use safeUp/safeDown to run migration code within a transaction
        public function safeUp()
        {
        }

        public function safeDown()
        {
        }
        */
    }
