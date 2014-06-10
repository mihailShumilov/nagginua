<?php

/**
 * This is the model base class for the table "lock_news".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "LockNews".
 *
 * Columns in table "lock_news" available as properties of the model,
 * followed by relations of table "lock_news" available as properties of the model.
 *
 * @property integer $id_news
 * @property string $created_at
 *
 * @property PendingNews $idNews
 */
abstract class BaseLockNews extends GxActiveRecord
{

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'lock_news';
    }

    public static function label($n = 1)
    {
        return Yii::t('app', 'LockNews|LockNews', $n);
    }

    public static function representingColumn()
    {
        return 'created_at';
    }

    public function rules()
    {
        return array(
            array('id_news', 'required'),
            array('id_news', 'numerical', 'integerOnly' => true),
            array('created_at', 'safe'),
            array('created_at', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id_news, created_at', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'idNews' => array(self::BELONGS_TO, 'PendingNews', 'id_news'),
        );
    }

    public function pivotModels()
    {
        return array();
    }

    public function attributeLabels()
    {
        return array(
            'id_news'    => null,
            'created_at' => Yii::t('app', 'Created At'),
            'idNews'     => null,
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id_news', $this->id_news);
        $criteria->compare('created_at', $this->created_at, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
}