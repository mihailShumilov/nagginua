<?php

Yii::import('application.models._base.BasePendingNews');

class PendingNews extends BasePendingNews
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}