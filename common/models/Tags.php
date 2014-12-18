<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "tags".
     *
     * @property integer $id
     * @property string $name
     * @property integer $cnt
     *
     * @property NewsHasTags[] $newsHasTags
     * @property News[] $news
     */
    class Tags extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'tags';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'cnt' ], 'integer' ],
                [ [ 'name' ], 'string', 'max' => 100 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'   => 'ID',
                'name' => 'Name',
                'cnt'  => 'Cnt',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNewsHasTags()
        {
            return $this->hasMany( NewsHasTags::className(), [ 'tag_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNews()
        {
            return $this->hasMany( News::className(), [ 'id' => 'news_id' ] )->viaTable( 'news_has_tags',
                [ 'tag_id' => 'id' ] );
        }

        public static function getPopular( $count = 10 )
        {
            return Tags::find()->orderBy( [ "cnt" => SORT_DESC ] )->limit( 10 )->all();
        }
    }
