<?php

Yii::import('application.models._base.BaseRssSources');

class RssSources extends BaseRssSources
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'source' => array(self::BELONGS_TO, 'Source', 'source_id'),
        );
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