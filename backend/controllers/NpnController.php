<?php

    namespace backend\controllers;

    use Yii;
    use common\models\Npn;
    use backend\models\NpnSearch;
    use yii\filters\AccessControl;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * NpnController implements the CRUD actions for Npn model.
     */
    class NpnController extends Controller
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
         * Lists all Npn models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel  = new NpnSearch();
            $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

            return $this->render( 'index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ] );
        }

        /**
         * Displays a single Npn model.
         *
         * @param integer $news_id
         * @param integer $pending_news_id
         *
         * @return mixed
         */
        public function actionView( $news_id, $pending_news_id )
        {
            return $this->render( 'view', [
                'model' => $this->findModel( $news_id, $pending_news_id ),
            ] );
        }

        /**
         * Creates a new Npn model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new Npn();

            if ($model->load( Yii::$app->request->post() ) && $model->save()) {
                return $this->redirect( [
                    'view',
                    'news_id'         => $model->news_id,
                    'pending_news_id' => $model->pending_news_id
                ] );
            } else {
                return $this->render( 'create', [
                    'model' => $model,
                ] );
            }
        }

        /**
         * Updates an existing Npn model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $news_id
         * @param integer $pending_news_id
         *
         * @return mixed
         */
        public function actionUpdate( $news_id, $pending_news_id )
        {
            $model = $this->findModel( $news_id, $pending_news_id );

            if ($model->load( Yii::$app->request->post() ) && $model->save()) {
                return $this->redirect( [
                    'view',
                    'news_id'         => $model->news_id,
                    'pending_news_id' => $model->pending_news_id
                ] );
            } else {
                return $this->render( 'update', [
                    'model' => $model,
                ] );
            }
        }

        /**
         * Deletes an existing Npn model.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         *
         * @param integer $news_id
         * @param integer $pending_news_id
         *
         * @return mixed
         */
        public function actionDelete( $news_id, $pending_news_id )
        {
            $this->findModel( $news_id, $pending_news_id )->delete();

            return $this->redirect( [ 'index' ] );
        }

        /**
         * Finds the Npn model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $news_id
         * @param integer $pending_news_id
         *
         * @return Npn the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel( $news_id, $pending_news_id )
        {
            if (( $model = Npn::findOne( [
                    'news_id'         => $news_id,
                    'pending_news_id' => $pending_news_id
                ] ) ) !== null
            ) {
                return $model;
            } else {
                throw new NotFoundHttpException( 'The requested page does not exist.' );
            }
        }
    }
