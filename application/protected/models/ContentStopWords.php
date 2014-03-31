<?php

Yii::import('application.models._base.BaseContentStopWords');

class ContentStopWords extends BaseContentStopWords
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}