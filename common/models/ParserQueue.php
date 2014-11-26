<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "parser_queue".
     *
     * @property integer $id
     * @property integer $source_id
     * @property string $url
     * @property string $status
     * @property string $created_at
     * @property string $updated_at
     *
     * @property LockParserQueue $lockParserQueue
     * @property NewsLinks[] $newsLinks
     * @property News[] $idNews
     * @property Sources $source
     * @property PendingNews[] $pendingNews
     */
    class ParserQueue extends \yii\db\ActiveRecord
    {
        const STATUS_NEW = 'new';
        const STATUS_INPROCESS = 'in_progress';
        const STATUS_APPROVED = 'approved';
        const STATUS_SUSPENDED = 'suspended';
        const STATUS_REJECTED = 'rejected';
        const STATUS_DONE = 'done';

        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'parser_queue';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'source_id', 'url' ], 'required' ],
                [ [ 'source_id' ], 'integer' ],
                [ [ 'url', 'status' ], 'string' ],
                [ [ 'created_at', 'updated_at' ], 'safe' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'source_id'  => 'Source ID',
                'url'        => 'Url',
                'status'     => 'Status',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getLockParserQueue()
        {
            return $this->hasOne( LockParserQueue::className(), [ 'id_parser_queue' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNewsLinks()
        {
            return $this->hasMany( NewsLinks::className(), [ 'id_pq' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getIdNews()
        {
            return $this->hasMany( News::className(), [ 'id' => 'id_news' ] )->viaTable( 'news_links',
                [ 'id_pq' => 'id' ] );
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
        public function getPendingNews()
        {
            return $this->hasMany( PendingNews::className(), [ 'pq_id' => 'id' ] );
        }
    }
