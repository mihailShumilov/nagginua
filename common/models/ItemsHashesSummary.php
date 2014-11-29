<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "items_hashes_summary".
     *
     * @property integer $doc_id
     * @property string $full_hash
     * @property integer $length
     */
    class ItemsHashesSummary extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'items_hashes_summary';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'doc_id', 'full_hash', 'length' ], 'required' ],
                [ [ 'doc_id', 'length' ], 'integer' ],
                [ [ 'full_hash' ], 'string', 'max' => 32 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'doc_id'    => 'Doc ID',
                'full_hash' => 'Full Hash',
                'length'    => 'Length',
            ];
        }
    }
