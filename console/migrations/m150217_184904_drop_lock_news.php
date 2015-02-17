<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150217_184904_drop_lock_news extends Migration
    {
        public function up()
        {
            $this->dropTable( "lock_news" );
        }

        public function down()
        {
            echo "m150217_184904_drop_lock_news cannot be reverted.\n";

            return false;
        }
    }
