<?php

class AdminModule extends CWebModule
{
    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array(
                'allow', // allow authorized user to access
                'actions' => array('index', 'layout', 'title', 'selectLayout', 'configLayout'),
                'users'   => array('@'),
            ),
            array(
                'allow', // alow any user to access
                'actions' => array('login', 'logout', 'error', 'maintenance'),
                'users'   => array('*'),
            ),
            array(
                'deny', // deny all users
                'users' => array('*'),
            ),
        );
    }


    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(
            array(
                'admin.models.*',
                'admin.components.*',
            )
        );
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            if (Yii::app()->user->isGuest) {
                Yii::app()->request->redirect("/site/login");
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
