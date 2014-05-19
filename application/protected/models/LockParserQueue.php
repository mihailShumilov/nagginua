<?php

Yii::import('application.models._base.BaseLockParserQueue');

class LockParserQueue extends BaseLockParserQueue
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}