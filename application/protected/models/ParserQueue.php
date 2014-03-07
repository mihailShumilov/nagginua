<?php

Yii::import('application.models._base.BaseParserQueue');

class ParserQueue extends BaseParserQueue
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}