<?php

class SettingsController extends GxController
{


    public function actionView($id)
    {
        $this->render(
            'view',
            array(
                'model' => $this->loadModel($id, 'Settings'),
            )
        );
    }

    public function actionCreate()
    {
        $model = new Settings;


        if (isset($_POST['Settings'])) {
            $model->setAttributes($_POST['Settings']);

            if ($model->save()) {
                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->end();
                } else {
                    $this->redirect(array('view', 'id' => $model->name));
                }
            }
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id, 'Settings');


        if (isset($_POST['Settings'])) {
            $model->setAttributes($_POST['Settings']);

            if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->name));
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
            $this->loadModel($id, 'Settings')->delete();

            if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
                $this->redirect(array('admin'));
            }
        } else {
            throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
        }
    }

    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Settings');
        $this->render(
            'index',
            array(
                'dataProvider' => $dataProvider,
            )
        );
    }

    public function actionAdmin()
    {
        $model = new Settings('search');
        $model->unsetAttributes();

        if (isset($_GET['Settings'])) {
            $model->setAttributes($_GET['Settings']);
        }

        $this->render(
            'admin',
            array(
                'model' => $model,
            )
        );
    }

}