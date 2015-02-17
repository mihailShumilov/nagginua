<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150217_191941_add_index_by_title extends Migration
    {
        public function up()
        {
            $this->execute( "CREATE INDEX title_idx ON pending_news USING gin(to_tsvector('russian', title))" );
        }

        public function down()
        {
            $this->dropIndex( 'title_idx', 'pending_news' );
        }
    }
