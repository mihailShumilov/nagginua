<?php

    namespace backend\controllers;

    use common\models\SourcesSettings;
    use Yii;
    use common\models\RssSources;
    use backend\models\RssSourcesSearch;
    use yii\filters\AccessControl;

    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * RssSourcesController implements the CRUD actions for RssSources model.
     */
    class RssSourcesController extends Controller
    {
        public function behaviors()
        {
            return [
                'access' => [
                    'class' => AccessControl::className(),
                    'rules' => [

                        [
                            'actions' => [ 'index', 'view', 'create', 'update', 'delete', 'find' ],
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

    /**
     * Lists all RssSources models.
     * @return mixed
     */
        public function actionIndex()
    {
        $searchModel  = new RssSourcesSearch();
        $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

        return $this->render( 'index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ] );
    }

        /**
         * Displays a single RssSources model.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionView( $id )
        {
            return $this->render( 'view', [
                'model' => $this->findModel( $id ),
            ] );
        }

        /**
         * Creates a new RssSources model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new RssSources();

            $postData = Yii::$app->request->post();

            if ($model->load( $postData ) && $model->save()) {
                if (isset( $postData['RssSources']['settings'] )) {
                    foreach ($postData['RssSources']['settings'] as $name => $value) {
                        $sourcesSettings            = new SourcesSettings();
                        $sourcesSettings->source_id = $model->source_id;
                        $sourcesSettings->name      = $name;
                        $sourcesSettings->value     = $value;
                        $sourcesSettings->save();
                    }
                }
                return $this->redirect( [ 'view', 'id' => $model->id ] );
            } else {
                return $this->render( 'create', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Updates an existing RssSources model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate( $id )
        {
            $model = $this->findModel( $id);

            $postData = Yii::$app->request->post();

            if ($model->load( $postData ) && $model->save()) {
                SourcesSettings::deleteAll( [ 'source_id' => $model->source_id ] );
                if (isset( $postData['RssSources']['settings'] )) {
                    foreach ($postData['RssSources']['settings'] as $name => $value) {
                        $sourcesSettings            = new SourcesSettings();
                        $sourcesSettings->source_id = $model->source_id;
                        $sourcesSettings->name      = $name;
                        $sourcesSettings->value     = $value;
                        $sourcesSettings->save();
                    }
                }

                return $this->redirect( [ 'view', 'id' => $model->id ] );
            } else {
                return $this->render( 'update', [
                    'model' => $model,
                ]);
            }
        }

        /**
         * Deletes an existing RssSources model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionDelete( $id )
        {
            $this->findModel( $id )->delete();

            return $this->redirect( [ 'index' ] );
        }

        /**
         * Finds the RssSources model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return RssSources the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel( $id )
        {
            if (( $model = RssSources::findOne( $id ) ) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException( 'The requested page does not exist.');
            }
    }
}
