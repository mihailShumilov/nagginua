<?php

    namespace common\models;

    use Yii;

    /**
     * This is the model class for table "rss_sources".
     *
     * @property integer $id
     * @property integer $source_id
     * @property string $url
     * @property integer $active
     * @property integer $is_full
     * @property integer $is_combine
     * @property string $created_at
     * @property string $updated_at
     */
    class RssSources extends \yii\db\ActiveRecord
    {
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'rss_sources';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'source_id', 'url' ], 'required' ],
                [ [ 'source_id', 'active', 'is_full', 'is_combine' ], 'integer' ],
                [ [ 'created_at', 'updated_at' ], 'safe' ],
                [ [ 'url' ], 'string', 'max' => 255 ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'source_id'  => 'Source ID',
                'url'        => 'Url',
                'active'     => 'Active',
                'is_full'    => 'Is Full',
                'is_combine' => 'Is Combine',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
            ];
        }
    }
