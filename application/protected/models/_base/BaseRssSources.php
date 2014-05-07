<?php

/**
 * This is the model base class for the table "rss_sources".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "RssSources".
 *
 * Columns in table "rss_sources" available as properties of the model,
 * followed by relations of table "rss_sources" available as properties of the model.
 *
 * @property integer $id
 * @property integer $source_id
 * @property string $url
 * @property integer $active
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Sources $source
 */
abstract class BaseRssSources extends GxActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'rss_sources';
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'RssSources|RssSources', $n);
    }

    public static function representingColumn()
    {
        return 'url';
    }

    public function rules()
    {
        return array(
            array('source_id, url', 'required'),
            array('source_id, active', 'numerical', 'integerOnly' => true),
            array('url', 'length', 'max' => 255),
            array('created_at, updated_at', 'safe'),
            array('active, created_at, updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, source_id, url, active, created_at, updated_at', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'source' => array(self::BELONGS_TO, 'Sources', 'source_id'),
        );
    }

    public function pivotModels()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'id'         => Yii::t('app', 'ID'),
            'source_id'  => null,
            'url'        => Yii::t('app', 'Url'),
            'active'     => Yii::t('app', 'Active'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'source'     => null,
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('source_id', $this->source_id);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('active', $this->active);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}