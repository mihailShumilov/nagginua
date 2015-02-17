<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m150217_205551_add_title_similar_weight extends Migration
    {
        public function up()
        {
            $this->update( 'settings', [ 'value' => '0.5' ], [ 'name' => 'similar_weight' ] );
            $this->insert( 'settings', [ 'name' => 'title_similar_weight', 'value' => '0.8' ] );

        }

        public function down()
        {
            echo "m150217_205551_add_title_similar_weight cannot be reverted.\n";

            return false;
        }
    }
