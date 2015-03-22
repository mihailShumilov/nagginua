<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150322_095622_add_category_order extends Migration
    {
        public function up()
        {
            $this->execute( 'ALTER TABLE categories
  ADD COLUMN "order" integer;' );
        }

        public function down()
        {
            $this->dropColumn( 'categories', 'order' );
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
