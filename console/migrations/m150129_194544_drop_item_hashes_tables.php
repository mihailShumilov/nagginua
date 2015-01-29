<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150129_194544_drop_item_hashes_tables extends Migration
    {
        public function up()
        {
            $this->execute( "DROP TABLE items_hashes" );
            $this->execute( "DROP TABLE items_hashes_summary" );
        }

        public function down()
        {
            echo "m150129_194544_drop_item_hashes_tables cannot be reverted.\n";

            return false;
        }
    }
