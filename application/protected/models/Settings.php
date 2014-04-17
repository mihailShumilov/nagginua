<?php

Yii::import('application.models._base.BaseSettings');

class Settings extends BaseSettings
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}