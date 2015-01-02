<?php

    namespace backend\controllers;

    use Yii;
    use common\models\ContentStopWords;
    use backend\models\ContentStopWordsSearch;
    use yii\filters\AccessControl;

    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * ContentStopWordsController implements the CRUD actions for ContentStopWords model.
     */
    class ContentStopWordsController extends Controller
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
                'verbs' => [
                    'class'   => VerbFilter::className(),
                    'actions' => [
                        'delete' => [ 'post' ],
                    ],
                ],
            ];
        }

        /**
         * Lists all ContentStopWords models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel  = new ContentStopWordsSearch();
            $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

            return $this->render( 'index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ] );
        }

        /**
         * Displays a single ContentStopWords model.
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
         * Creates a new ContentStopWords model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new ContentStopWords();

            if ($model->load( Yii::$app->request->post() ) && $model->save()) {
                return $this->redirect( [ 'view', 'id' => $model->id ] );
            } else {
                return $this->render( 'create', [
                    'model' => $model,
                ] );
            }
        }

        /**
         * Updates an existing ContentStopWords model.
         * If update is successful, the browser will be redirected to the 'view' page.
         *
         * @param integer $id
         *
         * @return mixed
         */
        public function actionUpdate( $id )
        {
            $model = $this->findModel( $id );

            if ($model->load( Yii::$app->request->post() ) && $model->save()) {
                return $this->redirect( [ 'view', 'id' => $model->id ] );
            } else {
                return $this->render( 'update', [
                    'model' => $model,
                ] );
            }
        }

        /**
         * Deletes an existing ContentStopWords model.
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
         * Finds the ContentStopWords model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return ContentStopWords the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel( $id )
        {
            if (( $model = ContentStopWords::findOne( $id ) ) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException( 'The requested page does not exist.' );
            }
        }
    }
