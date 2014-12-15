<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "category_words".
     *
     * @property integer $id
     * @property integer $category_id
     * @property string $word
     *
     * @property Categories $category
     */
    class CategoryWords extends \yii\db\ActiveRecord
    {
    /**
     * @inheritdoc
     */
        public static function tableName()
    {
        return 'category_words';
    }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'category_id' ], 'required' ],
                [ [ 'category_id' ], 'integer' ],
                [ [ 'word' ], 'string', 'max' => 255 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'          => 'ID',
                'category_id' => 'Category ID',
                'word'        => 'Word',
            ];
    }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getCategory()
        {
            return $this->hasOne( Categories::className(), [ 'id' => 'category_id' ] );
        }
    }
