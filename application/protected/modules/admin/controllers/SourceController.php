<?php

class SourceController extends GxController
{


    public function actionView($id)
    {
        $this->render(
            'view',
            array(
                'model' => $this->loadModel($id, 'Source'),
            )
        );
    }

    public function actionCreate()
    {
        $model = new Source;


        if (isset($_POST['Source'])) {
            $model->setAttributes($_POST['Source']);

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
        $model = $this->loadModel($id, 'Source');


        if (isset($_POST['Source'])) {
            $model->setAttributes($_POST['Source']);

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
            $this->loadModel($id, 'Source')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Source');
        $this->render(
            'index',
            array(
                'dataProvider' => $dataProvider,
            )
        );
    }

    public function actionAdmin()
    {
        $model = new Source('search');
        $model->unsetAttributes();

        if (isset($_GET['Source'])) {
            $model->setAttributes($_GET['Source']);
        }

        $this->render(
            'admin',
            array(
                'model' => $model,
            )
        );
    }

}