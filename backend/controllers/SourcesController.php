<?php

    namespace backend\controllers;

    use Yii;
    use common\models\Sources;
    use backend\models\SourcesSearch;
    use yii\filters\AccessControl;

    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * SourcesController implements the CRUD actions for Sources model.
     */
    class SourcesController extends Controller
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
         * Lists all Sources models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel  = new SourcesSearch();
            $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

            return $this->render( 'index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ] );
        }

        /**
         * Displays a single Sources model.
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
         * Creates a new Sources model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new Sources();

            if ($model->load( Yii::$app->request->post() ) && $model->save()) {
                return $this->redirect( [ 'view', 'id' => $model->id ] );
            } else {
                return $this->render( 'create', [
                    'model' => $model,
                ] );
            }
        }

        /**
         * Updates an existing Sources model.
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
         * Deletes an existing Sources model.
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
         * Finds the Sources model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return Sources the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel( $id )
        {
            if (( $model = Sources::findOne( $id ) ) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException( 'The requested page does not exist.' );
            }
        }
    }
