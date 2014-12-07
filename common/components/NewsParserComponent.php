<?php
    namespace common\components;


    use Yii;
    use yii\base\Component;
    use common\components\PageLoaderComponent;
    use common\models\SourcesSettings;
    use common\models\ParserQueue;
    use common\models\PendingNews;
    use common\models\ItemsHashes;
    use common\models\ItemsHashesSummary;
    use common\models\ContentStopWords;
    use common\models\TitleStopWords;
    use common\models\ExcludeElements;
    use common\models\Settings;
    use yii\base\Exception;

    require_once( 'vendor/mihailshumilov/documenthash/DocumentHash.php' );
    require_once( 'vendor/mihailshumilov/readability/Readability.php' );

    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 08.03.14
     * Time: 23:43
     */
    class NewsParserComponent extends Component
    {

        /**
         * @var Source Sources
         */
        private $source;
        private $url;
        /**
         * @var ParserQueue ParserQueue
         */
        private $parserQueue;
        /**
         * @var PendingNews PendingNews
         */
        private $pendingNews;

        /**
         * @param ParserQueue $pq
         * @param PendingNews $pn
         */
        public function __construct( ParserQueue $pq, PendingNews $pn = null )
        {
            $pq->status = ParserQueue::STATUS_INPROCESS;
            $pq->save();
            $this->source      = $pq->source;
            $this->url         = $this->prepareUrl( $pq->url );
            $this->parserQueue = $pq;
            if ($pn) {
                $this->pendingNews = $pn;
            }
        }

        public static function replace4byte( $string )
        {
            return html_entity_decode( mb_convert_encoding( $string, 'HTML-ENTITIES',
                "UTF-8" ) );
        }

        public function run()
        {
            echo "Try parse `{$this->url}`\n";
            if ($html = PageLoaderComponent::load( $this->url )) {
                try {
                    if (function_exists( 'tidy_parse_string' )) {
                        $tidy = tidy_parse_string( $html, array(), 'UTF8' );
                        $tidy->cleanRepair();
                        $html = $tidy->value;
                    }

                    $readability                          = new \Readability( $html, $this->url );
                    $readability->debug                   = false;
                    $readability->convertLinksToFootnotes = false;
                    $result                               = $readability->init();
                    if ($result) {
                        $title   = $readability->getTitle()->textContent;
                        $title   = $this->processTitleStopWords( $title );
                        $content = $readability->getContent()->innerHTML;
                        $content = $this->processContentStopWords( $content );
                        $content = preg_replace( '/\n/', ' ', $content );
                        $content = strip_tags( $content, "<p><div><img><span><br><ul><li><embed><iframe>" );
                        $content = $this->fixUrls( $content );
                        if (function_exists( 'tidy_parse_string' )) {
                            $tidy = tidy_parse_string( $content, array( 'show-body-only' => true, 'wrap' => 0 ),
                                'UTF8' );
                            $tidy->cleanRepair();
                            $content = $tidy->value;
                        }
//                echo $content;
//                echo "\nURL: {$this->url}\n";

                        $content = $this->processExcludeElements( $content );
                        if ($date = $this->processPublishDate( $html )) {
                            if ( ! ( date( "Y-m-d" ) == date( "Y-m-d", $date ) )) {
                                throw new Exception( "Old post" );
                            }
                        }


                        if ($searchContent = trim( strip_tags( $content ) )) {

                            $searchContent = preg_replace( '/\n/', ' ', $searchContent );
                            $searchContent = preg_replace( "/[^а-яa-z ]/ui", "", $searchContent );
                            $searchContent = preg_replace( '/\s+/', ' ', $searchContent );
                            $searchContent = html_entity_decode( mb_convert_encoding( $searchContent, 'HTML-ENTITIES',
                                    "UTF-8" ) );
                            $searchContent = preg_replace( "/[^а-яa-z ]/ui", "", $searchContent );

                            if (count( explode( " ",
                                        $searchContent ) ) >= Settings::findOne( [ 'name' => 'news_min_length' ] )->value
                            ) {
                                if ($this->pendingNews) {
                                    $this->pendingNews->content        = $content;
                                    $this->pendingNews->search_content = self::replace4byte( $searchContent );
                                    $this->pendingNews->status         = PendingNews::STATUS_NEW;

                                    if ( ! $this->pendingNews->thumb_src) {
                                        $this->pendingNews->thumb_src = $this->detectThumb( $html, $content );
                                    }
                                    if ($this->pendingNews->save()) {
                                        $this->parserQueue->status = ParserQueue::STATUS_DONE;
                                        $this->parserQueue->save();
                                        $this->fillSearchDB( $searchContent, $this->pendingNews->id );
                                        return true;
                                    } else {
                                        print_r( $this->pendingNews->getErrors() );
                                        $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                                        $this->parserQueue->save();
                                    }
                                } else {
                                    $pn                 = new PendingNews();
                                    $pn->source_id      = $this->source->id;
                                    $pn->title          = $title;
                                    $pn->content        = $content;
                                    $pn->search_content = self::replace4byte( $searchContent );
                                    $pn->status         = PendingNews::STATUS_NEW;
                                    $pn->group_hash     = md5( time() );
                                    $pn->thumb_src      = $this->detectThumb( $html, $content );
                                    $pn->pq_id          = $this->parserQueue->id;
                                    $pn->created_at = new \yii\db\Expression( "NOW()" );
                                    if ($pn->save()) {
                                        $this->parserQueue->status = ParserQueue::STATUS_DONE;
                                        $this->parserQueue->save();
                                        $this->fillSearchDB( $searchContent, $pn->id );

                                        $mq = new RabbitMQComponent();
                                        $mq->postMessage( "compile", "compile", json_encode( [ "pn_id" => $pn->id ] ) );

                                        return true;
                                    } else {
                                        print_r( $pn->getErrors() );
                                        $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                                        $this->parserQueue->save();
                                    }
                                }
                            } else {
                                $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                                $this->parserQueue->save();
                            }
                        }
                    } else {
                        throw new Exception( 'Looks like we couldn\'t find the content. :(' );
                    }
                } catch ( Exception $e ) {
//                echo "\n";
//                print_r($e->getMessage());
//                echo "\n";

                    $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                    $this->parserQueue->save();
                }
            } else {
                $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                $this->parserQueue->save();
            }
        }

        private function prepareUrl( $link )
        {
            if (strpos( $link, "http" ) === false) {
                return $this->source->url . $link;
            } else {
                return $link;
            }
        }

        private function processContentStopWords( $content )
        {
            foreach (ContentStopWords::findAll( [ "source_id" => $this->source->id ] ) as $csw) {
                if ($pos = strpos( $content, $csw->word )) {
                    $content = substr( $content, 0, $pos );
                }
            }
            return $content;
        }

        private function processTitleStopWords( $title )
        {
            foreach (TitleStopWords::findAll( [ "source_id" => $this->source->id ] ) as $csw) {
                if ($pos = strpos( $title, $csw->word )) {
                    $title = substr( $title, 0, $pos );
                }
            }
            return $title;
        }

        private function fixUrls( $content )
        {
            $content = preg_replace( '/src=("(\/[^"]+)")/', "src=\"{$this->source->url}$2\"", $content );
            return $content;
        }

        private function fixUrl( $url )
        {
            if ("/" == substr( $url, 0, 1 )) {
                $url = $this->source->url . $url;
            }
            return $url;
        }

        private function fillSearchDB( $content, $newsID )
        {
            $dh = new \DocumentHash( $content );

            $ihs            = new ItemsHashesSummary();
            $ihs->doc_id    = $newsID;
            $ihs->full_hash = $dh->docMD5;
            $tockens        = array_unique( $dh->getCrc32array() );
            $ihs->length    = sizeof( $tockens );
            $ihs->save();

            foreach ($tockens as $token) {
                $ih            = new ItemsHashes();
                $ih->doc_id    = $newsID;
                $ih->word_hash = $token;
                if ( ! $ih->save()) {
//                print_r($ih->getErrors());
//                die;
                }
            }

        }

        private function detectThumb( $html, $preparedHtml )
        {
            $thumbSrc = false;
            if ($this->source->thumb_pattern) {

                $doc                     = new \DOMDocument();
                $doc->preserveWhiteSpace = false;
                libxml_use_internal_errors( true );
                $doc->loadHTML( $html );
                $xpath = new \DOMXpath( $doc );
                if ($elements = $xpath->query( $this->source->thumb_pattern )->item( 0 )) {
                    $thumbSrc = $this->fixUrl( $elements->attributes->getNamedItem( 'src' )->nodeValue );
                }
            }

            if ( ! $thumbSrc) {
                if (preg_match_all( '/(https?:\/\/[a-z0-9\/_а-я\-\.]*\.(?:png|jpg))/i', $preparedHtml, $images )) {
                    $thumbSrc = $images[1][0];
                }
            }
            return $thumbSrc;
        }

        private function processExcludeElements( $html )
        {
            if ($patterns = ExcludeElements::findAll(
                array( "source_id" => $this->source->id )
            )
            ) {
                $htmlDoc                 = mb_convert_encoding( $html, 'HTML-ENTITIES', "UTF-8" );
                $doc                     = new \DOMDocument( "1.0", "utf-8" );
                $doc->preserveWhiteSpace = false;
                libxml_use_internal_errors( true );
                $doc->loadHTML( $htmlDoc );
                $xpath = new \DOMXpath( $doc );

                foreach ($patterns as $pattern) {
                    if ($element = $xpath->query( $pattern->pattern )->item( 0 )) {
                        $replace = $doc->saveHTML( $element );
                        $html    = str_replace( $replace, '', $html );
                    }

                }
            }
            return $html;
        }

        private function processPublishDate( $html )
        {

            if ($patterns = SourcesSettings::findAll( [
                'source_id' => $this->source->id,
                'name'      => 'date_pattern'
            ] )
            ) {
                $doc                     = new \DOMDocument( "1.0", "utf-8" );
                $doc->preserveWhiteSpace = false;
                libxml_use_internal_errors( true );
                $doc->loadHTML( $html );
                $xpath = new \DOMXpath( $doc );

                foreach ($patterns as $pattern) {

                    if ($publishDate = $xpath->evaluate( $pattern->value )) {
                        $publishDate = strtotime( $publishDate );
                        return $publishDate;
                    }
                }
            }
        }

        public function parse( $html, $url, Source $source = null )
        {
            if ($source) {
                $this->source = $source;
            }
            try {
                $parsedNews = array();
                if (function_exists( 'tidy_parse_string' )) {
                    $tidy = tidy_parse_string( $html, array(), 'UTF8' );
                    $tidy->cleanRepair();
                    $html = $tidy->value;
                }

                $readability                          = new \Readability( $html, $url );
                $readability->debug                   = false;
                $readability->convertLinksToFootnotes = false;
                $result                               = $readability->init();
                if ($result) {
                    $title   = $readability->getTitle()->textContent;
                    $title   = $this->processTitleStopWords( $title );
                    $content = $readability->getContent()->innerHTML;
                    $content = $this->processContentStopWords( $content );
                    $content = preg_replace( '/\n/', ' ', $content );
                    $content = strip_tags( $content, "<p><div><img><span><br><ul><li><embed><iframe>" );
                    $content = $this->fixUrls( $content );
                    if (function_exists( 'tidy_parse_string' )) {
                        $tidy = tidy_parse_string( $content, array( 'show-body-only' => true, 'wrap' => 0 ), 'UTF8' );
                        $tidy->cleanRepair();
                        $content = $tidy->value;
                    }

                    $content = $this->processExcludeElements( $content );

                    $date = $this->processPublishDate( $html );


                    if ($searchContent = trim( strip_tags( $content ) )) {

                        $searchContent = preg_replace( '/\n/', ' ', $searchContent );
                        $searchContent = preg_replace( "/[^а-яa-z ]/ui", "", $searchContent );
                        $searchContent = preg_replace( '/\s+/', ' ', $searchContent );
                        $searchContent = mb_convert_encoding( $searchContent, 'HTML-ENTITIES', "UTF-8" );

                        $parsedNews['title']         = $title;
                        $parsedNews['content']       = $content;
                        $parsedNews['searchContent'] = $searchContent;
                        $parsedNews['thumb']         = $this->detectThumb( $html, $content );
                        $parsedNews['date']          = $date;


                    }
                } else {
                    throw new Exception( 'Looks like we couldn\'t find the content. :(' );
                }
            } catch ( Exception $e ) {
                $parsedNews['error'] = $e->getMessage();

            }
            return $parsedNews;
        }

    }