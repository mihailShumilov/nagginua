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
        private $minSimiar = 0;

        public function __construct( PendingNews $pn )
        {
            $this->news      = $pn;
            $this->minSimiar = Settings::findOne( [ 'name' => 'similar_weight' ] )->value;
        }

        public function detect()
        {
            if ($data = $this->searchByContent()) {
                $ids_to_update = [ ];
                foreach ($data as $ids) {

                    if ($ids['weight'] > $this->minSimiar) {
                        $ids_to_update[$ids['id']] = $ids['weight'];
                    }
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
            return $this->search( $this->news->title );
        }

        public function searchByContent( $index_name = 'search_content' )
        {
            return $this->search( $this->news->search_content, $index_name );
        }

        public function searchByTitleContent( $index_name = 'search_content' )
        {
            return $this->search( $this->news->title . ", " . $this->news->search_content, $index_name );
        }

        protected function search( $content, $index_name = 'search_content' )
        {
            if ($content) {
                $returnIds = array();
                $dh        = new \DocumentHash( $content );
                if ($results = ItemsHashesSummary::findAll( [ "full_hash" => $dh->docMD5, "length" => $dh->length ] )
                ) {
                    foreach ($results as $ihs) {
                        $returnIds[] = array( 'id' => $ihs->doc_id, 'weight' => 100 );
                    }
                }
                $hashClause = "0 = 0";

                foreach ($dh->getCrc32array() as $token_hash) {
                    $hashClause .= " OR word_hash=$token_hash";
                }


                $findCmd = Yii::$app->db->createCommand( "SELECT doc_id, COUNT(id) as inters FROM items_hashes WHERE 1 = 1 AND ($hashClause) GROUP BY doc_id HAVING COUNT(id)>1" );

                $dataReader = $findCmd->query();
                while (( $row = $dataReader->read() ) !== false) {
                    $result2     = ItemsHashesSummary::findOne( [ "doc_id" => $row['doc_id'] ] );
                    $length      = $result2->length;
                    $length      = min( $length, $dh->length );
                    $weight      = ( $row['inters'] / $length ) * 100;
                    $returnIds[] = array( 'id' => $row['doc_id'], 'weight' => $weight );
                }

                return $returnIds;
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
            $categoryWords = CategoryWords::find()->all();
            $pn            = PendingNews::findOne( $pn_id );
            $content       = mb_strtolower( $pn->search_content, 'utf-8' );

            foreach ($categoryWords as $cw) {
                if (mb_strpos( $content, mb_strtolower( $cw->word, 'utf-8' ), 0, 'utf-8' )) {
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