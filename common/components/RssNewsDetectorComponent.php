<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 26.11.14
     * Time: 06:30
     */

    namespace common\components;

    use Yii;
    use yii\base\Component;
    use common\components\PageLoaderComponent;
    use common\models\SourcesSettings;
    use common\models\ParserQueue;
    use common\models\PendingNews;
    use common\models\RssSources;


    class RssNewsDetectorComponent extends Component
    {
        private $source;
        private $mq;

        public function __construct( RssSources $source )
        {
            echo "Start parsing: {$source->source->label}\n";
            $this->source = $source;
            $this->mq = new RabbitMQComponent();
        }

        public function run()
        {


            if ($rss = PageLoaderComponent::load( $this->source->url )) {
                $doc                     = new \DOMDocument();
                $doc->preserveWhiteSpace = false;
                libxml_use_internal_errors( true );
                $doc->loadXML( $rss );
                $xpath = new \DOMXpath( $doc );

                if ($this->source->is_combine) {
                    $this->processCombine( $xpath );
                } else {
                    $this->parseLinks( $xpath );
                }
            }
        }

        private function parseLinks( $xpath )
        {
            $patterns = SourcesSettings::findAll( [
                    'source_id' => $this->source->source_id,
                    'name'      => 'rss_news_pattern'
            ] );
            foreach ($patterns as $pattern) {

                if ($newsLinks = $xpath->query( $pattern->value )) {
                    for ($i = 0; $i < $newsLinks->length; $i ++) {
                        $item = $newsLinks->item( $i );
                        $url  = str_replace( $this->source->source->url, '', $item->nodeValue );
                        try {
                            $pqItem             = new ParserQueue();
                            $pqItem->source_id  = $this->source->source_id;
                            $pqItem->url        = $url;
                            $pqItem->status     = ParserQueue::STATUS_NEW;
                            $pqItem->created_at = new  \yii\db\Expression( 'NOW()' );
                            if ($pqItem->save()) {

                            } else {
//                                print_r( $pqItem->getErrors() );
                            }
                        } catch ( \yii\db\Exception $e ) {

                        }
                    }
                }
            }
        }

        private function processCombine( $xpath )
        {
            $itemPatterns = SourcesSettings::findAll( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_news_item_pattern'
            ] );
            if ($titlePattern = SourcesSettings::findOne( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_title'
            ] )
            ) {
                $titlePattern = $titlePattern->value;
            }
            if ($contentPattern = SourcesSettings::findOne( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_content'
            ] )
            ) {
                $contentPattern = $contentPattern->value;
            }
            if ($linkPattern = SourcesSettings::findOne( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_link'
            ] )
            ) {
                $linkPattern = $linkPattern->value;
            }
            if ($imagePattern = SourcesSettings::findOne( [
                'source_id' => $this->source->source_id,
                'name'      => 'rss_image'
            ] )
            ) {
                $imagePattern = $imagePattern->value;
            }



            foreach ($itemPatterns as $pattern) {

                if ($newsList = $xpath->query( $pattern->value )) {
                    for ($i = 0; $i < $newsList->length; $i ++) {
                        $news                 = $newsList->item( $i );

                        $newsParams           = array();
                        $newsParams['source'] = $this->source->source;
                        foreach ($news->childNodes as $node) {
                            if ($titlePattern == $node->nodeName) {
                                $newsParams['title'] = $node->nodeValue;
                            }
                            if ($linkPattern == $node->nodeName) {
                                $newsParams['link'] = str_replace( $this->source->source->url, '', $node->nodeValue );
//                            $newsParams['link'] = $node->nodeValue;
                            }
                            if ($imagePattern == $node->nodeName) {
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
                        }
                        try {
                            if (array_key_exists( "link", $newsParams )) {

                                $pqItem             = new ParserQueue();
                                $pqItem->source_id  = $this->source->source_id;
                                $pqItem->url        = $newsParams['link'];
                                $pqItem->status     = ParserQueue::STATUS_INPROCESS;
                                $pqItem->created_at = new \yii\db\Expression( 'NOW()' );
                                $pqItem->updated_at = new \yii\db\Expression( 'NOW()' );
                                if ($pqItem->save()) {

                                    $pn                 = new PendingNews();
                                    $pn->content        = '&nbsp;';
                                    $pn->search_content = '&nbsp;';
                                    $pn->source_id      = $this->source->source_id;
                                    if (isset( $newsParams['title'] )) {
                                        $pn->title = $newsParams['title'];
                                    }
                                    $pn->status = PendingNews::STATUS_SUSPENDED;
                                    $pn->group_hash = md5( time() );
                                    if (isset( $newsParams['image_src'] )) {
                                        $pn->thumb_src = $newsParams['image_src'];
                                    }
                                    if ($pqItem) {
                                        $pn->pq_id = $pqItem->id;
                                    }
                                    $pn->created_at = new \yii\db\Expression( "NOW()" );
                                    $pn->update_at = new \yii\db\Expression( "NOW()" );
                                    if ($pn->save()) {
                                        if ($pqItem) {
                                            $pqItem->status = ParserQueue::STATUS_DONE;
                                            $pqItem->save();
                                            $this->mq->postMessage( "parse", "parse_rss",
                                                json_encode( [ "pn_id" => $pn->id, "pq_id" => $pqItem->id ] ) );
                                        }

                                    } else {
                                        if ($pqItem) {
                                            $pqItem->status = ParserQueue::STATUS_FAIL;
                                            $pqItem->save();
                                        }
                                    }
                                } else {
//                                    print_r( $pqItem->errors );
                                }
                            }

                        } catch ( \yii\db\Exception $e ) {
//                            print_r( $e->getMessage() );
                        }

                    }
                }
            }
        }

    }