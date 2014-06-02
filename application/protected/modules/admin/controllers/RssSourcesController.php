<?php

class RssSourcesController extends GxController
{


    public function actionView($id)
    {
        $this->render(
            'view',
            array(
                'model' => $this->loadModel($id, 'RssSources'),
            )
        );
    }

    public function actionCreate()
    {
        $model = new RssSources;


        if (isset($_POST['RssSources'])) {
            $model->setAttributes($_POST['RssSources']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->end();
                } else {
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id, 'RssSources');


        if (isset($_POST['RssSources'])) {
            $model->setAttributes($_POST['RssSources']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render(
            'update',
            array(
                'model' => $model,
            )
        );
    }

    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            $this->loadModel($id, 'RssSources')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('RssSources');
        $this->render(
            'index',
            array(
                'dataProvider' => $dataProvider,
            )
        );
    }

    public function actionAdmin()
    {
        $model = new RssSources('search');
        $model->unsetAttributes();

        if (isset($_GET['RssSources'])) {
            $model->setAttributes($_GET['RssSources']);
        }

        $this->render(
            'admin',
            array(
                'model' => $model,
            )
        );
    }

}