<?php

    namespace common\models;

    use Yii;
    use yii\db\Expression;
    use common\models\NewsHasCategory;

    /**
     * This is the model class for table "news".
     *
     * @property integer $id
     * @property string $title
     * @property string $thumb
     * @property string $status
     * @property string $created_at
     * @property string $updated_at
     * @property integer $cnt
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
                [ [ 'created_at', 'updated_at' ], 'safe' ],
                [ [ 'cnt' ], 'integer' ]
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
                'cnt' => 'Cnt',
            ];
        }

        public function beforeSave( $insert )
        {
            if ($insert) {
                $this->created_at = new Expression( "NOW()" );
            }
            return parent::beforeSave( $insert );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNewsHasCategories()
        {
            return $this->hasMany( NewsHasCategory::className(), [ 'news_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNpns()
        {
            return $this->hasMany( Npn::className(), [ 'news_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPendingNews()
        {
            return $this->hasMany( PendingNews::className(),
                [ 'id' => 'pending_news_id' ] )->viaTable( Npn::tableName(),
                [ 'news_id' => 'id' ] );
        }

        public function getThumbLink( $type = "thumbNews" )
        {
            $ts = strtotime( $this->created_at );
            return '/uploads/' . date( "Y", $ts ) . '/' . date( "m", $ts ) . "/" . date( "d",
                $ts ) . "/" . $this->id . "/" . $type . ".png";
        }

        public function getLink()
        {
            return '/news/' . $this->id;
        }

        public function getShort( $length = 150 )
        {
            $npn = Npn::find()->where( [ 'news_id' => $this->id ] )->orderBy( [ 'pending_news_id' => SORT_DESC ] )->limit( 1 )->one();
            $pn  = PendingNews::findOne( $npn->pending_news_id );
            return mb_substr( $pn->search_content, 0, $length, 'utf-8' );
        }

        public function getCategoryList()
        {
            return Categories::find()->join( 'inner join', NewsHasCategory::tableName(),
                NewsHasCategory::tableName() . ".category_id = " . Categories::tableName() . ".id" )->where( [ NewsHasCategory::tableName() . ".news_id" => $this->id ] )->all();
        }

        public static function getLatestNews( $count = 4 )
        {
            return News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( $count )->all();
        }

        public static function getPopularNews( $count = 4 )
        {
            return News::find()->where( "created_at BETWEEN DATE_ADD(NOW(), INTERVAL -1 day) AND NOW()" )->orderBy( [ "cnt" => SORT_DESC ] )->limit( $count )->all();
        }
    }
