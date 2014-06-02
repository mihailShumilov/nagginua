<?php

class ExcludeElementsController extends GxController
{


    public function actionView($id)
    {
        $this->render(
            'view',
            array(
                'model' => $this->loadModel($id, 'ExcludeElements'),
            )
        );
    }

    public function actionCreate()
    {
        $model = new ExcludeElements;


        if (isset($_POST['ExcludeElements'])) {
            $model->setAttributes($_POST['ExcludeElements']);

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
        $model = $this->loadModel($id, 'ExcludeElements');


        if (isset($_POST['ExcludeElements'])) {
            $model->setAttributes($_POST['ExcludeElements']);

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
            $this->loadModel($id, 'ExcludeElements')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('ExcludeElements');
        $this->render(
            'index',
            array(
                'dataProvider' => $dataProvider,
            )
        );
    }

    public function actionAdmin()
    {
        $model = new ExcludeElements('search');
        $model->unsetAttributes();

        if (isset($_GET['ExcludeElements'])) {
            $model->setAttributes($_GET['ExcludeElements']);
        }

        $this->render(
            'admin',
            array(
                'model' => $model,
            )
        );
    }

}