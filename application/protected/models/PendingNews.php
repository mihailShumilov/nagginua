<?php

Yii::import('application.models._base.BasePendingNews');

class PendingNews extends BasePendingNews
{

    const STATUS_NEW = 'pending';

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

    protected function beforeSave()
    {
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->created_at = new CDbExpression('NOW()');
                $this->update_at  = new CDbExpression('NOW()');
            } else {
                $this->update_at = new CDbExpression('NOW()');
            }
            return true;
        } else {
            return false;
        }
    }
}