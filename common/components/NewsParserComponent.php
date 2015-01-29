<?php
    namespace common\components;


    use common\models\Sources;
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
    use \ForceUTF8\Encoding;

    require_once( Yii::getAlias( '@vendor' ) . '/mihailshumilov/documenthash/DocumentHash.php' );
    require_once( Yii::getAlias( '@vendor' ) . '/mihailshumilov/readability/Readability.php' );

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
            return $string;
        }

        public function run()
        {
            echo "Try parse `{$this->url}`\n";
            if ($html = PageLoaderComponent::load( $this->url )) {

                preg_match( '/<meta.*?charset=("?|\")(.*?)("|\")/i', $html, $matches );
                if (isset( $matches[2] )) {

                    if ($charset = $matches[2]) {
                        $html = mb_convert_encoding( $html, "UTF-8", $charset );
                    } else {
                        echo "ERROR ON ENCODING DETECTING";
                    }
                } else {
                    if ($defaultEncoding = SourcesSettings::findOne( [
                        'source_id' => $this->source->id,
                        'name'      => 'default_encoding'
                    ] )
                    ) {
                        $html = mb_convert_encoding( $html, "UTF-8", $defaultEncoding->value );
                    } else {
                        $html = mb_convert_encoding( $html, "UTF-8" );
                    }

                }

                try {
                    $html = $this->stripTagWithContent( $html, "script" );
                    $htmlToDetect = $this->processExcludeElements( $html );
                    $content      = $this->tryContentDetect( $htmlToDetect );

                    $readability                          = new \Readability( $html, $this->url );
                    $readability->debug                   = false;
                    $readability->convertLinksToFootnotes = false;
                    $result                               = $readability->init();
                    if ($result) {
                        $title                      = $readability->getTitle()->textContent;
                        $title                      = $this->processTitleStopWords( $title );
                        if ( ! $content) {
                            $content = $readability->getContent()->innerHTML;
                        }
                        $content = $this->processContentStopWords( $content );
                        $content = preg_replace( '/\n/', ' ', $content );
                        $content                    = strip_tags( $content,
                            "<p><div><img><span><br><ul><li><embed><iframe><strong><h1><h2><h3><h4>" );
                        $content = $this->fixUrls( $content );


                        $content = $this->processExcludeElements( $content );
                        if ($date = $this->processPublishDate( $html )) {
                            if ( ! ( date( "Y-m-d" ) == date( "Y-m-d", $date ) )) {
                                throw new Exception( "Old post" );
                            }
                        }


                        if ($searchContent = trim( strip_tags( $content ) )) {


                            $searchContent = preg_replace( '/\n/', ' ', $searchContent );

                            if (count( explode( " ",
                                    $searchContent ) ) >= Settings::findOne( [ 'name' => 'news_min_length' ] )->value
                            ) {
                                if ($this->pendingNews) {


                                    $this->pendingNews->content        = $content;
                                    $this->pendingNews->search_content = $searchContent;
                                    $this->pendingNews->status         = PendingNews::STATUS_NEW;

                                    if ( ! $this->pendingNews->thumb_src) {
                                        if ($thumbUrl = $this->detectThumb( $html, $content )) {
                                            $this->pendingNews->thumb_src = $thumbUrl;
                                        }
                                    }
                                    if ($this->pendingNews->save()) {

                                        try {
                                            PendingNews::fillTags( $this->pendingNews->search_content,
                                                $this->pendingNews->id );
                                        } catch ( \Exception $e ) {
                                            print_r( $e->getMessage() );
                                        }

                                        $mq = new RabbitMQComponent();
                                        $mq->postMessage( "compile", "compile",
                                            json_encode( [ "pn_id" => $this->pendingNews->id ] ) );

                                        $this->parserQueue->status = ParserQueue::STATUS_DONE;
                                        $this->parserQueue->save();
                                        return true;
                                    } else {
                                        print_r( $this->pendingNews->getErrors() );
                                        $this->parserQueue->status = ParserQueue::STATUS_FAIL;
                                        $this->parserQueue->save();
                                    }
                                } else {

                                    echo PHP_EOL . "NEWS CREATION" . PHP_EOL;

                                    $pn                 = new PendingNews();
                                    $pn->source_id      = $this->source->id;
                                    $pn->title          = $title;
                                    $pn->content        = $content;
                                    $pn->search_content = $searchContent;
                                    $pn->status         = PendingNews::STATUS_NEW;
                                    $pn->group_hash     = md5( time() );
                                    $pn->thumb_src      = $this->detectThumb( $html, $content );
                                    $pn->pq_id          = $this->parserQueue->id;
                                    $pn->created_at = new \yii\db\Expression( "NOW()" );
                                    if ($pn->save()) {
                                        $this->parserQueue->status = ParserQueue::STATUS_DONE;
                                        $this->parserQueue->save();
                                        return true;
                                    } else {
                                        echo PHP_EOL . "ERROR" . PHP_EOL;
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
                if ($pos = mb_strpos( $content, $csw->word, null, "utf-8" )) {
                    $content = mb_substr( $content, 0, $pos, "utf-8" );
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
            if ($html) {
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
            }
            return $html;
        }

        private function stripTagWithContent( $html, $tag )
        {
            $html = mb_convert_encoding( $html, 'HTML-ENTITIES', "UTF-8" );
            $dom  = new \DOMDocument( "1.0", "utf-8" );
            libxml_use_internal_errors( true );
            $dom->preserveWhiteSpace = false;
            $dom->loadHTML( $html );


            $elements = $dom->getElementsByTagName( $tag );
            while ($el = $elements->item( 0 )) {
                $el->parentNode->removeChild( $el );
            }

            return $dom->saveHTML();
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

        private function tryContentDetect( $html )
        {
            if ($patterns = SourcesSettings::findAll( [
                'source_id' => $this->source->id,
                'name'      => 'content_pattern'
            ] )
            ) {
                $doc                     = new \DOMDocument( "1.0", "utf-8" );
                $doc->preserveWhiteSpace = false;
                libxml_use_internal_errors( true );
                $doc->loadHTML( $html );
                $xpath         = new \DOMXpath( $doc );
                $contentResult = false;
                foreach ($patterns as $pattern) {

                    if ($content = $xpath->evaluate( $pattern->value )) {
                        $contentResult .= $doc->saveHTML( $content->item( 0 ) );
                    }
                }
                return $contentResult;
            }
            return false;
        }

        public function parse( $html, $url, Sources $source = null )
        {
            if ($source) {
                $this->source = $source;
            }
            try {
                $parsedNews = array();

                $html = $this->stripTagWithContent( $html, "script" );
                $htmlToDetect = $this->processExcludeElements( $html );
                $content      = $this->tryContentDetect( $htmlToDetect );

                $readability                          = new \Readability( $html, $url );
                $readability->debug                   = false;
                $readability->convertLinksToFootnotes = false;
                $result                               = $readability->init();
                if ($result || $content) {
                    $title = $readability->getTitle()->textContent;
                    $title = $this->processTitleStopWords( $title );
                    if ( ! $content) {
                        $content = $readability->getContent()->innerHTML;
                    }
                    $content = $this->processContentStopWords( $content );
                    $content = preg_replace( '/\n/', ' ', $content );
                    $content = strip_tags( $content, "<p><div><img><span><br><ul><li><embed><iframe>" );
                    $content = $this->fixUrls( $content );

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