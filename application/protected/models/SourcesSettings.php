<?php

Yii::import('application.models._base.BaseSourcesSettings');

class SourcesSettings extends BaseSourcesSettings
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function get($sourceID, $key)
    {
        if ($st = SourcesSettings::model()->find(
            "source_id = :source_id and name = :key",
            array(":source_id" => $sourceID, ":key" => $key)
        )
        ) {
            return $st->value;
        }
    }

    public static function getAll($sourceID, $key)
    {
        return SourcesSettings::model()->findAll(
            "source_id = :source_id and name = :key",
            array(":source_id" => $sourceID, ":key" => $key)
        );
    }

    public function relations()
    {
        return array(
            'source' => array(self::BELONGS_TO, 'Source', 'source_id'),
        );
    }
}