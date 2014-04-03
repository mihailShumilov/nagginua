<?php

Yii::import('application.models._base.BaseTitleStopWords');

class TitleStopWords extends BaseTitleStopWords
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}