<?php

Yii::import('application.models._base.BaseLockNews');

class LockNews extends BaseLockNews
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function lock($pending_news_id)
    {
        try {
            if ($pending_news_id) {
                try {
                    $pn         = PendingNews::model()->findByPk($pending_news_id);
                    $pn->status = PendingNews::STATUS_INPROCESS;
                    $pn->save();
                    $ln             = new LockNews();
                    $ln->id_news    = $pending_news_id;
                    $ln->created_at = new CDbExpression("NOW()");
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

    public static function unLock($pending_news_id)
    {
        try {
            if ($pending_news_id) {
                try {
                    if (LockNews::model()->deleteByPk($pending_news_id)) {
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

    public static function isLocked($pending_news_id)
    {
        if (LockNews::model()->findByPk($pending_news_id)) {
            return true;
        } else {
            return false;
        }
    }
}