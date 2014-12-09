<?php

    namespace common\models;

    use Yii;
    use yii\db\Expression;

    /**
     * This is the model class for table "news".
     *
     * @property integer $id
     * @property string $title
     * @property string $thumb
     * @property string $status
     * @property string $created_at
     * @property string $updated_at
     */
    class News extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'news';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'title', 'thumb', 'status' ], 'string' ],
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
                'title'      => 'Title',
                'thumb'      => 'Thumb',
                'status'     => 'Status',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ];
        }

        public function beforeSave( $insert )
        {
            if ($insert) {
                $this->created_at = new Expression( "NOW()" );
            }
            return parent::beforeSave( $insert );
        }

        public function getThumbLink( $type = "thumbNews" )
        {
            return '/uploads/' . date( "Y" ) . '/' . date( "m" ) . "/" . date( "d" ) . "/" . $this->id . "/" . $type . ".jpg";
        }

        public function getLink()
        {
            return '/' . $this->id;
        }

        public function getShort( $length = 150 )
        {
            $npn = Npn::find()->where( [ 'news_id' => $this->id ] )->orderBy( [ 'pending_news_id' => SORT_DESC ] )->limit( 1 )->one();
            $pn  = PendingNews::findOne( $npn->pending_news_id );
            return mb_substr( $pn->search_content, 0, $length, 'utf-8' );
        }
    }
