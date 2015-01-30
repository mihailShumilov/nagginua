<?php

    namespace common\components;

    use Yii;
    use yii\base\Component;
    use common\components\PageLoaderComponent;
    use common\models\SourcesSettings;
    use common\models\ParserQueue;
    use common\models\PendingNews;
    use common\models\RssSources;

    class RssNewsParserComponent extends Component
    {

        private $source;

        private $itemPatterns;

        private $titlePattern;

        private $contentPattern;

        private $linkPattern;

        private $imagePattern;

        public function __construct( RssSources $source )
        {
            echo "Start parsing: {$source->source->label}\n";
            $this->source = $source;

            $this->itemPatterns = SourcesSettings::findAll( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_news_item_pattern'
            ] );

            if ($titlePattern = SourcesSettings::findOne( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_title'
            ] )
            ) {
                $this->titlePattern = $titlePattern->value;
            }
            if ($contentPattern = SourcesSettings::findOne( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_content'
            ] )
            ) {
                $this->contentPattern = $contentPattern->value;
            }
            if ($linkPattern = SourcesSettings::findOne( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_link'
            ] )
            ) {
                $this->linkPattern = $linkPattern->value;
            }
            if ($imagePattern = SourcesSettings::findOne( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_image'
            ] )
            ) {
                $this->imagePattern = $imagePattern->value;
            }

        }

        public function run()
        {
            $rss                     = PageLoaderComponent::load( $this->source->url );

            preg_match( '/<\?xml.*?encoding=(\'|")(.*)("|\")/i', $rss, $matches );
            $charset = "utf-8";
            if (isset( $matches[2] )) {
                $charset = $matches[2];
//                $rss     = mb_convert_encoding( $rss, "UTF-8", $charset );
            } else {
//                $rss = mb_convert_encoding( $rss, "UTF-8" );
            }

            $doc = new \DOMDocument( "1.1", $charset );
            $doc->preserveWhiteSpace = false;
            libxml_use_internal_errors( true );
            $doc->loadXML( $rss );
            $xpath = new \DOMXpath( $doc );

            foreach ($this->itemPatterns as $pattern) {
                if ($newsList = $xpath->query( $pattern->value )) {

                    for ($i = 0; $i < $newsList->length; $i ++) {
                        $news                 = $newsList->item( $i );
                        $newsParams           = array();
                        $newsParams['source'] = $this->source->source;
                        foreach ($news->childNodes as $node) {
                            if ($this->titlePattern == $node->nodeName) {
                                $newsParams['title'] = $node->nodeValue;
                            }
                            if ($this->contentPattern == $node->nodeName) {
                                $newsParams['content'] = $node->nodeValue;
                            }
                            if ($this->linkPattern == $node->nodeName) {
                                $newsParams['link'] = $node->nodeValue;
                            }
                            if ($this->imagePattern == $node->nodeName) {
                                if (preg_match_all(
                                    '/(https?:\/\/[a-z0-9\/_а-я\-\.]*\.(?:png|jpg))/i',
                                    $node->nodeValue,
                                    $images
                                )
                                ) {
                                    $newsParams['image_src'] = $images[1][0];
                                }
                            }
                            if ( ! isset( $newsParams['image_src'] )) {
                                if ($node->nodeName == 'enclosure') {
                                    if (preg_match_all(
                                        '/(https?:\/\/[a-z0-9\/_а-я\-\.]*\.(?:png|jpg))/i',
                                        $node->getAttribute( 'url' ),
                                        $images
                                    )
                                    ) {
                                        $newsParams['image_src'] = $images[1][0];
                                    }
                                }
                            }
                            if ( ! isset( $newsParams['image_src'] )) {
                                $newsParams['image_src'] = "";
                            }
                        }

                        try {
                            $pqItem = ParserQueue::findOne( [ 'url' => $newsParams['link'] ] );
                            if ( ! $pqItem) {
                                $pqItem             = new ParserQueue();
                                $pqItem->source_id  = $this->source->source_id;
                                $pqItem->url        = $newsParams['link'];
                                $pqItem->status     = ParserQueue::STATUS_INPROCESS;
                                $pqItem->created_at = new \yii\db\Expression( 'NOW()' );
                                $pqItem->updated_at = new \yii\db\Expression( 'NOW()' );
                                if ($pqItem->save()) {

                                    PendingNews::add(
                                        $newsParams['source'],
                                        $newsParams['title'],
                                        $newsParams['content'],
                                        isset( $newsParams['image_src'] ) ? $newsParams['image_src'] : false,
                                        PendingNews::STATUS_NEW,
                                        $pqItem
                                    );


                                }
                            }
                        } catch ( Exception $e ) {
//                            print_r( $e->getMessage() );
                        }

                    }
                }
            }
        }
    }