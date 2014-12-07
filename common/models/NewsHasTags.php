<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "news_has_tags".
     *
     * @property integer $news_id
     * @property integer $tag_id
     *
     * @property News $news
     * @property Tags $tag
     */
    class NewsHasTags extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'news_has_tags';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'news_id', 'tag_id' ], 'required' ],
                [ [ 'news_id', 'tag_id' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'news_id' => 'News ID',
                'tag_id'  => 'Tag ID',
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
        public function getTag()
        {
            return $this->hasOne( Tags::className(), [ 'id' => 'tag_id' ] );
        }
    }
