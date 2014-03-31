<?php

/**
 * This is the model base class for the table "content_stop_words".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ContentStopWords".
 *
 * Columns in table "content_stop_words" available as properties of the model,
 * followed by relations of table "content_stop_words" available as properties of the model.
 *
 * @property integer $id
 * @property integer $source_id
 * @property string $word
 *
 * @property Sources $source
 */
abstract class BaseContentStopWords extends GxActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'content_stop_words';
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'ContentStopWords|ContentStopWords', $n);
    }

    public static function representingColumn()
    {
        return 'word';
    }

    public function rules()
    {
        return array(
            array('source_id, word', 'required'),
            array('source_id', 'numerical', 'integerOnly' => true),
            array('word', 'length', 'max' => 255),
            array('id, source_id, word', 'safe', 'on' => 'search'),
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
            'id'        => Yii::t('app', 'ID'),
            'source_id' => null,
            'word'      => Yii::t('app', 'Word'),
            'source'    => null,
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('source_id', $this->source_id);
        $criteria->compare('word', $this->word, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}