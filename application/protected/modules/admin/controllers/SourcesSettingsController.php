<?php

class SourcesSettingsController extends GxController
{


    public function actionView($id)
    {
        $this->render(
            'view',
            array(
                'model' => $this->loadModel($id, 'SourcesSettings'),
            )
        );
    }

    public function actionCreate()
    {
        $model = new SourcesSettings;


        if (isset($_POST['SourcesSettings'])) {
            $model->setAttributes($_POST['SourcesSettings']);

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
        $model = $this->loadModel($id, 'SourcesSettings');


        if (isset($_POST['SourcesSettings'])) {
            $model->setAttributes($_POST['SourcesSettings']);

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
            $this->loadModel($id, 'SourcesSettings')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('SourcesSettings');
        $this->render(
            'index',
            array(
                'dataProvider' => $dataProvider,
            )
        );
    }

    public function actionAdmin()
    {
        $model = new SourcesSettings('search');
        $model->unsetAttributes();

        if (isset($_GET['SourcesSettings'])) {
            $model->setAttributes($_GET['SourcesSettings']);
        }

        $this->render(
            'admin',
            array(
                'model' => $model,
            )
        );
    }

}