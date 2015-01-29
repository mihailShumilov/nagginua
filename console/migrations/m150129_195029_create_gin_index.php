<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150129_195029_create_gin_index extends Migration
    {
        public function up()
        {
            $this->execute( "CREATE INDEX content_search_idx ON pending_news USING gin(to_tsvector('russian', search_content))" );
        }

        public function down()
        {
            echo "m150129_195029_create_gin_index cannot be reverted.\n";

            return false;
        }
    }
