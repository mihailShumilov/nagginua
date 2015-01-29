<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150129_193341_alter_seq extends Migration
    {
        public function up()
        {
            $this->execute( "SELECT setval('categories_id_seq', (SELECT max(id) FROM categories))" );
            $this->execute( "SELECT setval('category_words_id_seq', (SELECT max(id) FROM category_words))" );
            $this->execute( "SELECT setval('content_stop_words_id_seq', (SELECT max(id) FROM content_stop_words))" );
            $this->execute( "SELECT setval('exclude_elements_id_seq', (SELECT max(id) FROM exclude_elements))" );
            $this->execute( "SELECT setval('items_hashes_id_seq', (SELECT max(id) FROM items_hashes))" );
            $this->execute( "SELECT setval('news_has_category_id_seq', (SELECT max(id) FROM news_has_category))" );
            $this->execute( "SELECT setval('news_id_seq', (SELECT max(id) FROM news))" );
            $this->execute( "SELECT setval('parser_queue_id_seq', (SELECT max(id) FROM parser_queue))" );
            $this->execute( "SELECT setval('pending_news_id_seq', (SELECT max(id) FROM pending_news))" );
            $this->execute( "SELECT setval('sources_id_seq', (SELECT max(id) FROM sources))" );
            $this->execute( "SELECT setval('sources_settings_id_seq', (SELECT max(id) FROM sources_settings))" );
            $this->execute( "SELECT setval('tags_id_seq', (SELECT max(id) FROM tags))" );
            $this->execute( "SELECT setval('title_stop_words_id_seq', (SELECT max(id) FROM title_stop_words))" );
            $this->execute( "SELECT setval('users_id_seq', (SELECT max(id) FROM users))" );

        }

        public function down()
        {
            echo "m150129_193341_alter_seq cannot be reverted.\n";

            return false;
        }
    }
