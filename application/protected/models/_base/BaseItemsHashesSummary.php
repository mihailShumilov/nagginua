<?php

/**
 * This is the model base class for the table "items_hashes_summary".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ItemsHashesSummary".
 *
 * Columns in table "items_hashes_summary" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $doc_id
 * @property string $full_hash
 * @property integer $length
 *
 */
abstract class BaseItemsHashesSummary extends GxActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'items_hashes_summary';
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'ItemsHashesSummary|ItemsHashesSummaries', $n);
    }

    public static function representingColumn()
    {
        return 'full_hash';
    }

    public function rules()
    {
        return array(
            array('doc_id, full_hash, length', 'required'),
            array('doc_id, length', 'numerical', 'integerOnly' => true),
            array('full_hash', 'length', 'max' => 32),
            array('doc_id, full_hash, length', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array();
    }

    public function pivotModels()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'doc_id'    => Yii::t('app', 'Doc'),
            'full_hash' => Yii::t('app', 'Full Hash'),
            'length'    => Yii::t('app', 'Length'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('doc_id', $this->doc_id);
        $criteria->compare('full_hash', $this->full_hash, true);
        $criteria->compare('length', $this->length);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}