<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "sources".
     *
     * @property integer $id
     * @property string $label
     * @property string $url
     * @property string $category_pattern
     * @property string $news_pattern
     * @property string $thumb_pattern
     * @property integer $active
     * @property string $created_at
     * @property string $updated_at
     *
     * @property ContentStopWords[] $contentStopWords
     * @property ExcludeElements[] $excludeElements
     * @property ParserQueue[] $parserQueues
     * @property PendingNews[] $pendingNews
     * @property SourcesSettings[] $sourcesSettings
     * @property TitleStopWords[] $titleStopWords
     */
    class Sources extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'sources';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'label', 'url' ], 'required' ],
                [ [ 'active' ], 'integer' ],
                [ [ 'created_at', 'updated_at' ], 'safe' ],
                [ [ 'label', 'url', 'category_pattern', 'news_pattern', 'thumb_pattern' ], 'string', 'max' => 255 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'               => 'ID',
                'label'            => 'Label',
                'url'              => 'Url',
                'category_pattern' => 'Category Pattern',
                'news_pattern'     => 'News Pattern',
                'thumb_pattern'    => 'Thumb Pattern',
                'active'           => 'Active',
                'created_at'       => 'Created At',
                'updated_at'       => 'Updated At',
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getContentStopWords()
        {
            return $this->hasMany( ContentStopWords::className(), [ 'source_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getExcludeElements()
        {
            return $this->hasMany( ExcludeElements::className(), [ 'source_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getParserQueues()
        {
            return $this->hasMany( ParserQueue::className(), [ 'source_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPendingNews()
        {
            return $this->hasMany( PendingNews::className(), [ 'source_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getSourcesSettings()
        {
            return $this->hasMany( SourcesSettings::className(), [ 'source_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getTitleStopWords()
        {
            return $this->hasMany( TitleStopWords::className(), [ 'source_id' => 'id' ] );
        }
    }
