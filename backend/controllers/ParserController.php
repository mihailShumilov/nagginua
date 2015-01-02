<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/22/14
     * Time: 05:41
     */

    namespace backend\controllers;

    use common\components\NewsParserComponent;
    use common\components\PageLoaderComponent;
    use common\models\ParserQueue;
    use common\models\Sources;
    use Yii;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\filters\VerbFilter;


    class ParserController extends Controller
    {

        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [

                        [
                            'actions' => [ 'test' ],
                            'allow'   => true,
                            'roles'   => [ '@' ],
                        ],
                    ],
                ],
                'verbs'  => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => [ 'post' ],
                    ],
                ],
            ];
        }


        public function actionTest()
        {
            $data = [ ];

            if (Yii::$app->request->post()) {
                $data = Yii::$app->request->post();
                if (isset( $data['url'] )) {

                    $parser               = new NewsParserComponent( ParserQueue::findOne( 1 ) );
                    $data['parserResult'] = $parser->parse( PageLoaderComponent::load( $data['url'] ), $data['url'],
                        Sources::findOne( $data['Source'] ) );
                }
            }

            return $this->render( 'test', $data );
        }
    }