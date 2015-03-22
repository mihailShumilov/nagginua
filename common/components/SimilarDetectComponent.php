<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 12/5/14
     * Time: 21:50
     */

    namespace common\components;

    use common\models\CategoryWords;
    use common\models\News;
    use common\models\NewsHasCategory;
    use common\models\Npn;
    use Yii;
    use common\models\ItemsHashesSummary;
    use common\models\PendingNews;
    use common\models\Settings;
    use yii\base\Component;
    use yii\db\Expression;

    require_once( 'vendor/mihailshumilov/documenthash/DocumentHash.php' );


    class SimilarDetectComponent extends Component
    {
        /**
         * @var PendingNews
         */
        private $news = false;
        private $titleSimilar = 0.8;
        private $contentSimilar = 0.5;

        public function __construct( PendingNews $pn )
        {
            if ($contentWeight = Settings::findOne( [ 'name' => 'similar_weight' ] )) {
                $this->contentSimilar = $contentWeight->value;
            }
            if ($titleWeight = Settings::findOne( [ 'name' => 'title_similar_weight' ] )) {
                $this->titleSimilar = $titleWeight->value;
            }
            $this->news      = $pn;
        }

        public function detect()
        {

            $data = $this->searchByTitle();
            if ( ! $data) {
                $data = $this->searchByContent();
            }

            if ($data) {
                $ids_to_update = [ ];
                foreach ($data as $ids) {
                    $ids_to_update[$ids['id']] = $ids['weight'];
                }
                if (array_key_exists( $this->news->id, $ids_to_update )) {
                    unset( $ids_to_update[$this->news->id] );
                }
                if ($ids_to_update) {
                    arsort( $ids_to_update );
                    reset( $ids_to_update );
                    $news_to_compile = key( $ids_to_update );

                    if ($npn = Npn::findOne( [ "pending_news_id" => $news_to_compile ] )) {
                        $this->linkNews( $npn->news_id, $this->news->id );

                    } else {
                        $this->linkNews( $this->createNews( $this->news ), $news_to_compile );
                    }

                } else {
                    $this->createNews( $this->news );
                }
            } else {
                $this->createNews( $this->news );
            }
        }

        protected function  searchByTitle()
        {
            return $this->search( $this->news->title, 'title', $this->titleSimilar );
        }

        public function searchByContent( $index_name = 'search_content' )
        {
            return $this->search( $this->news->search_content, $index_name, $this->contentSimilar );
        }

        public function searchByTitleContent( $index_name = 'search_content' )
        {
            return $this->search( $this->news->title . ", " . $this->news->search_content, $index_name );
        }

        protected function search( $content, $field = 'search_content', $similar_weight = 0.5 )
        {
            if ($content) {
                $returnIds = array();

                $findCmd = Yii::$app->db->createCommand( "SELECT id, title, similarity({$field}, :text) as sml
from pending_news
where
similarity({$field}, :text) > {$similar_weight}
and created_at > (NOW() - interval '24 hours')
and id <> {$this->news->id}
and search_content <> '&nbsp;'
order by sml desc" );


                $findCmd->bindParam( ":text", $content );

                if ($dataReader = $findCmd->query()) {
                    while (( $row = $dataReader->read() ) !== false) {
                        $returnIds[] = array( 'id' => $row['id'], 'weight' => $row['sml'] * 100 );
                    }
                }

                return empty( $returnIds ) ? false : $returnIds;
            } else {
                return false;
            }
        }

        protected function createNews( PendingNews $pn )
        {

            if ($npn = Npn::findOne( [ "pending_news_id" => $pn->id ] )) {
                return $npn->news_id;
            }

            $news             = new News();
            $news->title      = NewsParserComponent::replace4byte( $pn->title );
            $news->thumb      = $pn->thumb_src;
            $news->status     = "in_process";
            $news->cnt = 0;
            $news->created_at = new \yii\db\Expression( 'NOW()' );
            $news->updated_at = new \yii\db\Expression( 'NOW()' );
            if ($news->save()) {

                $this->linkNews( $news->id, $pn->id );

                $news->status = "done";
                $news->save();

                if ($news->thumb) {
                    $mq = new RabbitMQComponent();
                    $mq->postMessage( "image", "image",
                        json_encode( [ "news_id" => $news->id, "src" => $news->thumb ] ) );
                    $mq->postMessage( "twitter", "twitter",
                        json_encode( [ "news_id" => $news->id, "src" => $news->thumb ] ) );
                } else {
                    if ($giData = PageLoaderComponent::load( "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" . urlencode( $news->title ) . "&userip=127.0.0.1&imgsz=large" )) {
                        $data = json_decode( $giData );
                        if (isset( $data->responseData->results[0] )) {
                            $news->thumb = $data->responseData->results[0]->unescapedUrl;
                            $news->save();
                            $mq = new RabbitMQComponent();
                            $mq->postMessage( "image", "image", json_encode( [
                                "news_id" => $news->id,
                                "src"     => $data->responseData->results[0]->unescapedUrl
                            ] ) );
                            $mq->postMessage( "twitter", "twitter",
                                json_encode( [
                                    "news_id" => $news->id,
                                    "src"     => $data->responseData->results[0]->unescapedUrl
                                ] ) );
                        }
                    }
                }
            } else {
                print_r( $news->getErrors() );
            }

            return $news->id;
        }

        protected function linkNews( $news_id, $pn_id )
        {
            try {
                $npn                  = new Npn();
                $npn->news_id         = $news_id;
                $npn->pending_news_id = $pn_id;
                if ($npn->save()) {
                    $news = News::findOne( $news_id );
                    $news->updateCounters( [ 'cnt' => 1 ] );
                    $this->detectCategories( $news_id, $pn_id );
                }

            } catch ( \Exception $e ) {
                print_r( $e->getMessage() );
            }
        }


        protected function checkNewsThumb( $news_id, $pn_id )
        {
            $news = News::findOne( $news_id );
            if ( ! $news->thumb) {
                $pn          = PendingNews::findOne( $pn_id );
                $news->thumb = $pn->thumb_src;
                $news->save();
                $mq = new RabbitMQComponent();
                $mq->postMessage( "image", "image", json_encode( [ "news_id" => $news->id, "src" => $news->thumb ] ) );
            }
        }

        protected function detectCategories( $news_id, $pn_id )
        {
            $pn            = PendingNews::findOne( $pn_id );
            $content       = mb_strtolower( $pn->search_content, 'utf-8' );
            if ($pn->additonal_data) {
                $data = json_decode( $pn->additonal_data );
                if (isset( $data->category_id )) {
                    if ( ! $nhc = NewsHasCategory::findOne( [
                        'category_id' => $data->category_id,
                        'news_id'     => $news_id
                    ] )
                    ) {
                        $nhc              = new NewsHasCategory();
                        $nhc->news_id     = $news_id;
                        $nhc->category_id = $data->category_id;
                        $nhc->save();
                        return true;
                    }
                }
                if ($data->category) {
                    $content = mb_strtolower( $data->category, 'utf-8' );
                }
            }

            $categoryWords = CategoryWords::find()->all();

            foreach ($categoryWords as $cw) {
                if (mb_strpos( $content, mb_strtolower( $cw->word, 'utf-8' ), 0, 'utf-8' ) !== false) {
                    if ( ! $nhc = NewsHasCategory::findOne( [
                        'category_id' => $cw->category_id,
                        'news_id'     => $news_id
                    ] )
                    ) {
                        $nhc              = new NewsHasCategory();
                        $nhc->news_id     = $news_id;
                        $nhc->category_id = $cw->category_id;
                        $nhc->save();
                    }
                }
            }
        }
    }