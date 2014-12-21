<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "npn".
     *
     * @property integer $news_id
     * @property integer $pending_news_id
     *
     * @property News $news
     * @property PendingNews $pendingNews
     */
    class Npn extends \yii\db\ActiveRecord
    {
    /**
     * @inheritdoc
     */
        public static function tableName()
    {
        return 'npn';
    }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'news_id', 'pending_news_id' ], 'required' ],
                [ [ 'news_id', 'pending_news_id' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'news_id'         => 'News ID',
                'pending_news_id' => 'Pending News ID',
            ];
    }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNews()
        {
            return $this->hasOne( News::className(), [ 'id' => 'news_id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPendingNews()
        {
            return $this->hasOne( PendingNews::className(), [ 'id' => 'pending_news_id' ] );
        }
    }
