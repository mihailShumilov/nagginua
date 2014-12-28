<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 26.11.14
     * Time: 06:21
     */

    namespace console\controllers;

    use common\models\PendingNews;
    use Yii;
    use common\components\RabbitMQComponent;
    use common\models\RssSources;
    use common\components\RssNewsDetectorComponent;
    use common\components\RssNewsParserComponent;

    class ProcessOldController extends \yii\console\Controller
    {
        public function actionIndex()
        {
            foreach (PendingNews::find()->where( "id <= 4293" )->each() as $pn) {
                if ($pn->search_content) {
                    $mq = new RabbitMQComponent();
                    $mq->postMessage( "compile", "compile", json_encode( [ "pn_id" => $pn->id ] ) );
                }
            }
        }
    }
