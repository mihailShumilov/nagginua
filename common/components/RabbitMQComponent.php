<?php
    /**
     * Created by PhpStorm.
     * User: godson
     * Date: 19.11.14
     * Time: 17:29
     */

    namespace common\components;

    use Yii;
    use yii\base\Component;
    use PhpAmqpLib\Connection\AMQPConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    class RabbitMQComponent extends Component {

        private $host;
        private $port;
        private $user;
        private $pass;
        private $path;

        private $connection;
        private $channel;

        public function __construct(
            $host = "localhost",
            $port = 5672,
            $user = "guest",
            $pass = "guest",
            $path = "/"
        ) {
            $this->host = $host;
            $this->port = $port;
            $this->user = $user;
            $this->pass = $pass;
            $this->path = $path;
            $this->connect();
        }

        protected function connect() {
            $this->connection = new AMQPConnection( $this->host, $this->port, $this->user, $this->pass, $this->path );
            $this->channel    = $this->connection->channel();
        }

        public function postMessage( $queue, $route, $text ) {
            $this->channel->queue_declare( $queue, false, true, false, false );
            $this->channel->exchange_declare( $route, 'direct', false, true, false );
            $this->channel->queue_bind( $queue, $route );

            $msg = new AMQPMessage( $text, array( 'content_type' => 'application/json', 'delivery_mode' => 2 ) );
            $this->channel->basic_publish( $msg, $route );
        }

        public function __destruct() {
            if ( $this->channel ) {
                $this->channel->close();
            }
            if ( $this->connection ) {
                $this->connection->close();
            }
        }

        public function consume( $queue, $route, $callback ) {
            $this->channel->queue_declare( $queue, false, true, false, false );
            $this->channel->exchange_declare( $route, 'direct', false, true, false );
            $this->channel->queue_bind( $queue, $route );
            $this->channel->basic_consume( $queue, "consumer", false, false, false, false, $callback );

            while ( count( $this->channel->callbacks ) ) {
                $this->channel->wait();
            }
        }
    }