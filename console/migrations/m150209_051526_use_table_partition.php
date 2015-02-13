<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150209_051526_use_table_partition extends Migration
    {
        public function up()
        {
            $this->execute( 'DROP INDEX "public"."pending_news_fk_pending_news_2_idx";' );
            $this->execute( 'CREATE UNIQUE INDEX  "pending_news_fk_pending_news_2_idx" ON "public"."pending_news" USING btree(pq_id ASC NULLS LAST);' );
            $this->execute( 'ALTER TABLE "public"."news" ALTER COLUMN "created_at" SET NOT NULL;' );
//        $this->execute('CREATE SCHEMA partman;');
//        $this->execute('CREATE EXTENSION pg_partman SCHEMA partman;');
//        $this->execute("SELECT partman.create_parent('public.pending_news', 'created_at', 'time-static', 'daily');");
//        $this->execute("SELECT partman.create_parent('public.parser_queue', 'created_at', 'time-static', 'daily');");
//        $this->execute("SELECT partman.create_parent('public.news', 'created_at', 'time-static', 'daily');");

        }

        public function down()
        {
            echo "m150209_051526_use_table_partition cannot be reverted.\n";

            return false;
        }
    }
