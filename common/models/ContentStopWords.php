<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "content_stop_words".
     *
     * @property integer $id
     * @property integer $source_id
     * @property string $word
     *
     * @property Sources $source
     */
    class ContentStopWords extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'content_stop_words';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'source_id', 'word' ], 'required' ],
                [ [ 'source_id' ], 'integer' ],
                [ [ 'word' ], 'string', 'max' => 255 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'        => 'ID',
                'source_id' => 'Source ID',
                'word'      => 'Word',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getSource()
        {
            return $this->hasOne( Sources::className(), [ 'id' => 'source_id' ] );
        }
    }
