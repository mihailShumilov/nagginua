<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150304_135016_add_Additional_field extends Migration
    {
        public function up()
        {
            $this->execute( "ALTER TABLE pending_news ADD COLUMN additonal_data json;" );
        }

        public function down()
        {
            $this->dropColumn( 'pending_news', 'additional_data' );
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
