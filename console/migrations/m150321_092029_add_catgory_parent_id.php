<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150321_092029_add_catgory_parent_id extends Migration
    {
        public function up()
        {
            $this->execute( "ALTER TABLE categories ADD COLUMN parent_id integer;" );
        }

        public function down()
        {
            $this->dropColumn( 'categories', 'parent_id' );
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
