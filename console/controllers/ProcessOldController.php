<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 26.11.14
     * Time: 06:21
     */

    namespace console\controllers;

    use Yii;
    use common\components\RabbitMQComponent;
    use common\models\RssSources;
    use common\components\RssNewsDetectorComponent;
    use common\components\RssNewsParserComponent;

    class ProcessOldController extends \yii\console\Controller
    {
        public function actionIndex()
        {

        }
    }
