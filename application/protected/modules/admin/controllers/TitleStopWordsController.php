<?php

class TitleStopWordsController extends GxController
{


    public function actionView($id)
    {
        $this->render(
            'view',
            array(
                'model' => $this->loadModel($id, 'TitleStopWords'),
            )
        );
    }

    public function actionCreate()
    {
        $model = new TitleStopWords;


        if (isset($_POST['TitleStopWords'])) {
            $model->setAttributes($_POST['TitleStopWords']);

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
        $model = $this->loadModel($id, 'TitleStopWords');


        if (isset($_POST['TitleStopWords'])) {
            $model->setAttributes($_POST['TitleStopWords']);

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
            $this->loadModel($id, 'TitleStopWords')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('TitleStopWords');
        $this->render(
            'index',
            array(
                'dataProvider' => $dataProvider,
            )
        );
    }

    public function actionAdmin()
    {
        $model = new TitleStopWords('search');
        $model->unsetAttributes();

        if (isset($_GET['TitleStopWords'])) {
            $model->setAttributes($_GET['TitleStopWords']);
        }

        $this->render(
            'admin',
            array(
                'model' => $model,
            )
        );
    }

}