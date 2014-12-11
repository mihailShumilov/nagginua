<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m141211_221735_add_news_counter extends Migration
    {
        public function up()
        {
            $this->execute( "ALTER TABLE news ADD `cnt` INTEGER DEFAULT '0'" );
        }

        public function down()
        {
            $this->dropColumn( 'news', 'cnt' );
        }
    }
