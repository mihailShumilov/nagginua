<?php

    namespace common\models;

    use common\components\NewsParserComponent;
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

        public static function add(
            Sources $source,
            $title,
            $content,
            $image_src,
            $status = PendingNews::STATUS_NEW,
            ParserQueue $parser_queue = null
        ) {


            if ($searchContent = trim( strip_tags( $content ) )) {

                $searchContent = preg_replace( '/\n/', ' ', $searchContent );
                $searchContent = preg_replace( "/[^а-яa-z ]/ui", "", $searchContent );
                $searchContent = preg_replace( '/\s+/', ' ', $searchContent );
                $searchContent = NewsParserComponent::replace4byte( $searchContent );
                $searchContent = preg_replace( "/[^а-яa-z ]/ui", "", $searchContent );

                if (count( explode( " ",
                            $searchContent ) ) >= Settings::findOne( [ 'name' => 'news_min_length' ] )->value
                ) {

                    $pn                 = new PendingNews();
                    $pn->source_id      = $source->id;
                    $pn->title          = $title;
                    $pn->content        = $content;
                    $pn->search_content = $searchContent;
                    $pn->status         = $status;
                    $pn->group_hash     = md5( microtime() );
                    $pn->thumb_src      = $image_src;
                    if ($parser_queue) {
                        $pn->pq_id = $parser_queue->id;
                    }
                    $pn->created_at = new \yii\db\Expression( "NOW()" );
                    if ($pn->save()) {
                        if ($parser_queue) {
                            $parser_queue->status = ParserQueue::STATUS_DONE;
                            $parser_queue->save();
                        }
                        PendingNews::fillSearchDB( $searchContent, $pn->id );
                    } else {
                        if ($parser_queue) {
                            $parser_queue->status = ParserQueue::STATUS_FAIL;
                            $parser_queue->save();
                        }
                    }
                }
            }
        }

        public static function fillSearchDB( $content, $newsID )
        {
            $dh = new \DocumentHash( $content );

            $ihs            = new ItemsHashesSummary();
            $ihs->doc_id    = $newsID;
            $ihs->full_hash = $dh->docMD5;
            $tockens        = array_unique( $dh->getCrc32array() );
            $ihs->length    = sizeof( $tockens );
            $ihs->save();

            foreach ($tockens as $token) {
                $ih            = new ItemsHashes();
                $ih->doc_id    = $newsID;
                $ih->word_hash = $token;
                if ( ! $ih->save()) {
//                print_r($ih->getErrors());
//                die;
                }
            }

        }
    }
