<?php

Yii::import('application.models._base.BasePendingNews');

class PendingNews extends BasePendingNews
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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