<?php

    namespace common\models;

    use common\components\KeywordDetector;
    use common\components\NewsParserComponent;
    use common\components\RabbitMQComponent;
    use Yii;

    require_once( Yii::getAlias( '@vendor' ) . '/mihailshumilov/documenthash/DocumentHash.php' );

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
                    $pn->update_at = new \yii\db\Expression( "NOW()" );
                    if ($pn->save()) {
                        if ($parser_queue) {
                            $parser_queue->status = ParserQueue::STATUS_DONE;
                            $parser_queue->save();
                        }

                    } else {
                        if ($parser_queue) {
                            $parser_queue->status = ParserQueue::STATUS_FAIL;
                            $parser_queue->save();
                        }
                    }
                }
            }
        }



        public function afterSave( $insert, $changedAttributes )
        {

            if (( isset( $changedAttributes['search_content'] ) && ( ! empty( $changedAttributes['search_content'] ) ) && ( $changedAttributes['search_content'] != '&nbsp;' ) ) || ( $insert && ( mb_strlen( trim( $this->search_content ),
                            "utf-8" ) > 6 ) )
            ) {
                try {
                    self::fillTags( $this->search_content, $this->id );
                } catch ( \Exception $e ) {

                }
                $mq = new RabbitMQComponent();
                $mq->postMessage( "compile", "compile", json_encode( [ "pn_id" => $this->id ] ) );
            }
            return parent::afterSave( $insert, $changedAttributes );
        }

        public static function fillTags( $content, $id_news )
        {
            if ($tagList = KeywordDetector::detect( $content )) {
                foreach ($tagList as $tagName) {
                    $tagName = NewsParserComponent::replace4byte( $tagName );
                    $tag     = Tags::findOne( [ 'name' => $tagName ] );
                    if ( ! $tag) {
                        $tag       = new Tags();
                        $tag->name = $tagName;
                        $tag->cnt = 0;
                        $tag->save();
                    }

                    $nht          = new NewsHasTags();
                    $nht->news_id = $id_news;
                    $nht->tag_id  = $tag->id;
                    if ($nht->save()) {
                        $tag->updateCounters( [ 'cnt' => 1 ] );
                    }
                }
            }
        }
    }
