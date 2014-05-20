<?php

Yii::import('application.models._base.BaseLockParserQueue');

class LockParserQueue extends BaseLockParserQueue
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function lock($parser_queue_id)
    {
        try {
            if ($parser_queue_id) {
                try {
                    $ln                  = new LockParserQueue();
                    $ln->id_parser_queue = $parser_queue_id;
                    $ln->created_at      = new CDbExpression("NOW()");
                    if ($ln->save()) {
                        return true;
                    } else {
                        throw new CException(Yii::t('news', 'Can\'t lock news'));
                    }
                } catch (CDbException $e) {
                    throw new CException(Yii::t('news', 'News already locked'));
                }
            } else {
                throw new CException(Yii::t('news', 'News id must be set'));
            }
        } catch (CException $e) {
            return false;
        }
    }

    public static function unLock($parser_queue_id)
    {
        try {
            if ($parser_queue_id) {
                try {
                    if (LockParserQueue::model()->deleteByPk($parser_queue_id)) {
                        return true;
                    } else {
                        throw new CException(Yii::t('news', 'Can\'t unlock news'));
                    }
                } catch (CDbException $e) {
                    throw new CException(Yii::t('news', 'DB Error'));
                }
            } else {
                throw new CException(Yii::t('news', 'News id must be set'));
            }
        } catch (CException $e) {
            return false;
        }
    }

    public static function isLocked($parser_queue_id)
    {
        if (LockParserQueue::model()->findByPk($parser_queue_id)) {
            return true;
        } else {
            return false;
        }
    }
}