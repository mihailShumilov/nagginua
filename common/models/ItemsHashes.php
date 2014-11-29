<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "items_hashes".
     *
     * @property integer $id
     * @property integer $doc_id
     * @property integer $word_hash
     */
    class ItemsHashes extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'items_hashes';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'doc_id', 'word_hash' ], 'required' ],
                [ [ 'doc_id', 'word_hash' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'        => 'ID',
                'doc_id'    => 'Doc ID',
                'word_hash' => 'Word Hash',
            ];
        }
    }
