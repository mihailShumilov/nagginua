<?php

    namespace common\models;

    use Yii;
    use yii\db\Expression;
    use common\models\NewsHasCategory;
    use himiklab\sitemap\behaviors\SitemapBehavior;


    /**
     * This is the model class for table "news".
     *
     * @property integer $id
     * @property string $title
     * @property string $thumb
     * @property string $status
     * @property string $created_at
     * @property string $updated_at
     * @property integer $cnt
     */
    class News extends \yii\db\ActiveRecord
    {

        public function behaviors()
        {
            return [
                'sitemap' => [
                    'class'       => SitemapBehavior::className(),
                    'scope'       => function ( $model ) {
                        /** @var \yii\db\ActiveQuery $model */
                        $model->andWhere( [ 'status' => 'done' ] );
                    },
                    'dataClosure' => function ( $model ) {
                        /** @var self $model */
                        return [
                            'loc'        => $model->getLink(),
                            'lastmod'    => strtotime( $model->updated_at ),
                            'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                            'priority'   => 0.8
                        ];
                    }
                ],
            ];
        }
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
            return 'news';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [ [ 'title', 'thumb', 'status' ], 'string' ],
                [ [ 'created_at', 'updated_at' ], 'safe' ],
                [ [ 'cnt' ], 'integer' ]
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'id'         => 'ID',
                'title'      => 'Title',
                'thumb'      => 'Thumb',
                'status'     => 'Status',
                'created_at' => 'Created At',
                'updated_at' => 'Updated At',
                'cnt' => 'Cnt',
            ];
        }

        public function beforeSave( $insert )
        {
            if ($insert) {
                $this->title = html_entity_decode( $this->title );
                $this->created_at = new Expression( "NOW()" );
            }
            return parent::beforeSave( $insert );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNewsHasCategories()
        {
            return $this->hasMany( NewsHasCategory::className(), [ 'news_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getNpns()
        {
            return $this->hasMany( Npn::className(), [ 'news_id' => 'id' ] );
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPendingNews()
        {
            return $this->hasMany( PendingNews::className(),
                [ 'id' => 'pending_news_id' ] )->viaTable( Npn::tableName(),
                [ 'news_id' => 'id' ] );
        }

        public function getThumbLink( $type = "thumbNews" )
        {
            $ts = strtotime( $this->created_at );
            return '/uploads/' . date( "Y", $ts ) . '/' . date( "m", $ts ) . "/" . date( "d",
                $ts ) . "/" . $this->id . "/" . $type . ".png";
        }

        public function getLink()
        {
            return '/news/' . $this->id . "/" . urlencode( $this->get_in_translate_to_en( $this->title ) );
        }

        public function getShort( $length = 150 )
        {
            $npn = Npn::find()->where( [ 'news_id' => $this->id ] )->orderBy( [ 'pending_news_id' => SORT_DESC ] )->limit( 1 )->one();
            if ($pn = PendingNews::findOne( $npn->pending_news_id )) {
                return html_entity_decode( mb_substr( $pn->search_content, 0, $length, 'utf-8' ) );
            }
        }

        public function getCategoryList()
        {
            return Categories::find()->join( 'inner join', NewsHasCategory::tableName(),
                NewsHasCategory::tableName() . ".category_id = " . Categories::tableName() . ".id" )->where( [ NewsHasCategory::tableName() . ".news_id" => $this->id ] )->all();
        }

        public static function getLatestNews( $count = 4 )
        {
            return News::find()->orderBy( [ "id" => SORT_DESC ] )->limit( $count )->all();
        }

        public static function getPopularNews( $count = 4 )
        {
            return News::find()->where( "created_at BETWEEN NOW() - INTERVAL '1 day' AND NOW()" )->orderBy( [ "cnt" => SORT_DESC ] )->limit( $count )->all();
        }

        public function get_in_translate_to_en( $string, $gost = false )
        {
            if ($gost) {
                $replace = array(
                    "А" => "A",
                    "а" => "a",
                    "Б" => "B",
                    "б" => "b",
                    "В" => "V",
                    "в" => "v",
                    "Г" => "G",
                    "г" => "g",
                    "Д" => "D",
                    "д" => "d",
                    "Е" => "E",
                    "е" => "e",
                    "Ё" => "E",
                    "ё" => "e",
                    "Ж" => "Zh",
                    "ж" => "zh",
                    "З" => "Z",
                    "з" => "z",
                    "И" => "I",
                    "и" => "i",
                    "Й" => "I",
                    "й" => "i",
                    "К" => "K",
                    "к" => "k",
                    "Л" => "L",
                    "л" => "l",
                    "М" => "M",
                    "м" => "m",
                    "Н" => "N",
                    "н" => "n",
                    "О" => "O",
                    "о" => "o",
                    "П" => "P",
                    "п" => "p",
                    "Р" => "R",
                    "р" => "r",
                    "С" => "S",
                    "с" => "s",
                    "Т" => "T",
                    "т" => "t",
                    "У" => "U",
                    "у" => "u",
                    "Ф" => "F",
                    "ф" => "f",
                    "Х" => "Kh",
                    "х" => "kh",
                    "Ц" => "Tc",
                    "ц" => "tc",
                    "Ч" => "Ch",
                    "ч" => "ch",
                    "Ш" => "Sh",
                    "ш" => "sh",
                    "Щ" => "Shch",
                    "щ" => "shch",
                    "Ы" => "Y",
                    "ы" => "y",
                    "Э" => "E",
                    "э" => "e",
                    "Ю" => "Iu",
                    "ю" => "iu",
                    "Я" => "Ia",
                    "я" => "ia",
                    "ъ" => "",
                    "ь" => ""
                );
            } else {
                $arStrES = array( "ае", "уе", "ое", "ые", "ие", "эе", "яе", "юе", "ёе", "ее", "ье", "ъе", "ый", "ий" );
                $arStrOS = array( "аё", "уё", "оё", "ыё", "иё", "эё", "яё", "юё", "ёё", "её", "ьё", "ъё", "ый", "ий" );
                $arStrRS = array( "а$", "у$", "о$", "ы$", "и$", "э$", "я$", "ю$", "ё$", "е$", "ь$", "ъ$", "@", "@" );

                $replace = array(
                    "А" => "A",
                    "а" => "a",
                    "Б" => "B",
                    "б" => "b",
                    "В" => "V",
                    "в" => "v",
                    "Г" => "G",
                    "г" => "g",
                    "Д" => "D",
                    "д" => "d",
                    "Е" => "Ye",
                    "е" => "e",
                    "Ё" => "Ye",
                    "ё" => "e",
                    "Ж" => "Zh",
                    "ж" => "zh",
                    "З" => "Z",
                    "з" => "z",
                    "И" => "I",
                    "и" => "i",
                    "Й" => "Y",
                    "й" => "y",
                    "К" => "K",
                    "к" => "k",
                    "Л" => "L",
                    "л" => "l",
                    "М" => "M",
                    "м" => "m",
                    "Н" => "N",
                    "н" => "n",
                    "О" => "O",
                    "о" => "o",
                    "П" => "P",
                    "п" => "p",
                    "Р" => "R",
                    "р" => "r",
                    "С" => "S",
                    "с" => "s",
                    "Т" => "T",
                    "т" => "t",
                    "У" => "U",
                    "у" => "u",
                    "Ф" => "F",
                    "ф" => "f",
                    "Х" => "Kh",
                    "х" => "kh",
                    "Ц" => "Ts",
                    "ц" => "ts",
                    "Ч" => "Ch",
                    "ч" => "ch",
                    "Ш" => "Sh",
                    "ш" => "sh",
                    "Щ" => "Shch",
                    "щ" => "shch",
                    "Ъ" => "",
                    "ъ" => "",
                    "Ы" => "Y",
                    "ы" => "y",
                    "Ь" => "",
                    "ь" => "",
                    "Э" => "E",
                    "э" => "e",
                    "Ю" => "Yu",
                    "ю" => "yu",
                    "Я" => "Ya",
                    "я" => "ya",
                    "@" => "y",
                    "$" => "ye",
                    " " => "-"
                );

                $string = str_replace( $arStrES, $arStrRS, $string );
                $string = str_replace( $arStrOS, $arStrRS, $string );
            }

            return iconv( "UTF-8", "UTF-8//IGNORE", strtr( $string, $replace ) );
        }
    }
