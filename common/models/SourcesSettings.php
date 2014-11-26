<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "sources_settings".
     *
     * @property integer $id
     * @property integer $source_id
     * @property string $name
     * @property string $value
     *
     * @property Sources $source
     */
    class SourcesSettings extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'sources_settings';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'source_id', 'name' ], 'required' ],
                [ [ 'source_id' ], 'integer' ],
                [ [ 'value' ], 'string' ],
                [ [ 'name' ], 'string', 'max' => 255 ]
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
                'name'      => 'Name',
                'value'     => 'Value',
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
