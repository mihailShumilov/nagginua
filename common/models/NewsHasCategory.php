<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "news_has_category".
     *
     * @property integer $id
     * @property integer $category_id
     * @property integer $news_id
     */
    class NewsHasCategory extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'news_has_category';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'category_id', 'news_id' ], 'required' ],
                [ [ 'category_id', 'news_id' ], 'integer' ],
                [
                    [ 'category_id', 'news_id' ],
                    'unique',
                    'targetAttribute' => [ 'category_id', 'news_id' ],
                    'message'         => 'The combination of Category ID and News ID has already been taken.'
                ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id' => 'ID',
                'category_id' => 'Category ID',
                'news_id' => 'News ID',
            ];
        }
    }
