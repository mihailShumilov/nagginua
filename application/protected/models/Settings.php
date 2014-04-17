<?php

Yii::import('application.models._base.BaseSettings');

class Settings extends BaseSettings
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function get($key)
    {
        if ($st = Settings::model()->findByPk($key)) {
            return $st->value;
        } else {
            throw new CException(Yii::t("core", "Settings '$key' was not founded"));
        }
    }
}