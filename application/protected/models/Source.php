<?php

Yii::import('application.models._base.BaseSource');

class Source extends BaseSource
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 'active=1',
            ),
        );
    }
}