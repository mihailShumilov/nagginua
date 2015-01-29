<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150129_203815_create_trmg_ext extends Migration
    {
        public function up()
        {
            $this->execute( "CREATE EXTENSION pg_trgm" );
        }

        public function down()
        {
            echo "m150129_203815_create_trmg_ext cannot be reverted.\n";

            return false;
        }
    }
