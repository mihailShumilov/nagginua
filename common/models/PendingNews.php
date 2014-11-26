<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "pending_news".
     *
     * @property integer $id
     * @property integer $source_id
     * @property integer $pq_id
     * @property string $title
     * @property string $content
     * @property string $search_content
     * @property string $thumb_src
     * @property string $status
     * @property string $group_hash
     * @property integer $processed
     * @property string $created_at
     * @property string $update_at
     *
     * @property LockNews $lockNews
     * @property News[] $news
     * @property Sources $source
     * @property ParserQueue $pq
     */
    class PendingNews extends \yii\db\ActiveRecord
    {

        const STATUS_NEW = 'pending';
        const STATUS_INPROCESS = 'in_process';
        const STATUS_SUSPENDED = 'suspended';
        const STATUS_REJECTED = 'rejected';
        const STATUS_APPROVED = 'approved';
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'pending_news';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'source_id', 'title', 'content', 'search_content', 'group_hash' ], 'required' ],
                [ [ 'source_id', 'pq_id', 'processed' ], 'integer' ],
                [ [ 'title', 'content', 'search_content', 'thumb_src', 'status' ], 'string' ],
                [ [ 'created_at', 'update_at' ], 'safe' ],
                [ [ 'group_hash' ], 'string', 'max' => 45 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'             => 'ID',
                'source_id'      => 'Source ID',
                'pq_id'          => 'Pq ID',
                'title'          => 'Title',
                'content'        => 'Content',
                'search_content' => 'Search Content',
                'thumb_src'      => 'Thumb Src',
                'status'         => 'Status',
                'group_hash'     => 'Group Hash',
                'processed'      => 'Processed',
                'created_at'     => 'Created At',
                'update_at'      => 'Update At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getLockNews()
        {
            return $this->hasOne( LockNews::className(), [ 'id_news' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNews()
        {
            return $this->hasMany( News::className(), [ 'pending_news_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getSource()
        {
            return $this->hasOne( Sources::className(), [ 'id' => 'source_id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPq()
        {
            return $this->hasOne( ParserQueue::className(), [ 'id' => 'pq_id' ] );
        }
    }
