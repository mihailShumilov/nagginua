<?php

Yii::import('application.models._base.BaseLockNews');

class LockNews extends BaseLockNews
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}