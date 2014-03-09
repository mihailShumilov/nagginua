<?php

Yii::import('application.models._base.BaseParserQueue');

class ParserQueue extends BaseParserQueue
{

    const STATUS_NEW       = 'new';
    const STATUS_INPROCESS = 'in_progress';
    const STATUS_FAIL      = 'fail';
    const STATUS_DONE      = 'done';

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('source_id, url, created_at', 'required'),
            array('source_id', 'numerical', 'integerOnly' => true),
            array('status', 'length', 'max' => 11),
            array('updated_at', 'safe'),
            array('status', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, source_id, url, status, created_at, updated_at', 'safe', 'on' => 'search'),
            array(
                'updated_at',
                'default',
                'value'      => new CDbExpression('NOW()'),
                'setOnEmpty' => true,
                'on'         => 'update'
            ),
            array(
                'created_at,updated_at',
                'default',
                'value'      => new CDbExpression('NOW()'),
                'setOnEmpty' => true,
                'on'         => 'insert'
            )
        );
    }

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_at = new CDbExpression('NOW()');
                $this->updated_at = new CDbExpression('NOW()');
            } else {
                $this->updated_at = new CDbExpression('NOW()');
            }
            return true;
        } else {
            return false;
        }
    }
}