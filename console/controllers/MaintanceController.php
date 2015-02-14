<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 2/14/15
     * Time: 11:23
     */

    namespace console\controllers;

    use yii\console\Controller;
    use Yii;

    class MaintanceController extends Controller
    {
        public function actionIndex()
        {
            Yii::$app->db->createCommand( "VACUUM categories;" )->execute();
            Yii::$app->db->createCommand( "VACUUM category_words;" )->execute();
            Yii::$app->db->createCommand( "VACUUM content_stop_words;" )->execute();
            Yii::$app->db->createCommand( "VACUUM exclude_elements;" )->execute();
            Yii::$app->db->createCommand( "VACUUM migration;" )->execute();
            Yii::$app->db->createCommand( "VACUUM news;" )->execute();
            Yii::$app->db->createCommand( "VACUUM news_has_category;" )->execute();
            Yii::$app->db->createCommand( "VACUUM news_has_tags;" )->execute();
            Yii::$app->db->createCommand( "VACUUM npn;" )->execute();
            Yii::$app->db->createCommand( "VACUUM parser_queue;" )->execute();
            Yii::$app->db->createCommand( "VACUUM pending_news;" )->execute();
            Yii::$app->db->createCommand( "VACUUM rss_sources;" )->execute();
            Yii::$app->db->createCommand( "VACUUM settings;" )->execute();
            Yii::$app->db->createCommand( "VACUUM sources;" )->execute();
            Yii::$app->db->createCommand( "VACUUM sources_settings;" )->execute();
            Yii::$app->db->createCommand( "VACUUM tags;" )->execute();
            Yii::$app->db->createCommand( "VACUUM tbl_migration;" )->execute();
            Yii::$app->db->createCommand( "VACUUM title_stop_words;" )->execute();
            Yii::$app->db->createCommand( "VACUUM users;" )->execute();
        }
    }