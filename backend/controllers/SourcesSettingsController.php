<?php

    namespace backend\controllers;

    use Yii;
    use common\models\SourcesSettings;
    use backend\models\SourcesSettingsSearch;
    use yii\filters\AccessControl;

    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

    /**
     * SourcesSettingsController implements the CRUD actions for SourcesSettings model.
     */
    class SourcesSettingsController extends Controller
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
         * Lists all SourcesSettings models.
         * @return mixed
         */
        public function actionIndex()
        {
            $searchModel  = new SourcesSettingsSearch();
            $dataProvider = $searchModel->search( Yii::$app->request->queryParams );

            return $this->render( 'index', [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ] );
        }

        /**
         * Displays a single SourcesSettings model.
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
         * Creates a new SourcesSettings model.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate()
        {
            $model = new SourcesSettings();

            if ($model->load( Yii::$app->request->post() ) && $model->save()) {
                return $this->redirect( [ 'view', 'id' => $model->id ] );
            } else {
                return $this->render( 'create', [
                    'model' => $model,
                ] );
            }
        }

        /**
         * Updates an existing SourcesSettings model.
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
         * Deletes an existing SourcesSettings model.
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
         * Finds the SourcesSettings model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         *
         * @param integer $id
         *
         * @return SourcesSettings the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel( $id )
        {
            if (( $model = SourcesSettings::findOne( $id ) ) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException( 'The requested page does not exist.' );
            }
        }
    }
