<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "exclude_elements".
     *
     * @property integer $id
     * @property integer $source_id
     * @property string $pattern
     *
     * @property Sources $source
     */
    class ExcludeElements extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'exclude_elements';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'source_id', 'pattern' ], 'required' ],
                [ [ 'source_id' ], 'integer' ],
                [ [ 'pattern' ], 'string' ]
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
                'pattern'   => 'Pattern',
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
