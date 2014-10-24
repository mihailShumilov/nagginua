<?php

	/**
	 * Created by PhpStorm.
	 * User: godson
	 * Date: 25.08.14
	 * Time: 10:46
	 */
	class GetTaskCommand extends CConsoleCommand
	{
		public function run( $args )
		{
			$cnn = new AMQPConnection();
			$cnn->setHost( '127.0.0.1' );
			if ($cnn->connect()) {
				echo "Established a connection to the broker\n";
			} else {
				echo "Cannot connect to the broker\n";
			}

			$ch = new AMQPChannel( $cnn );
			// Declare a new exchange
//        $ex = new AMQPExchange($ch);
//        $ex->setName('new_topic_exchange');
//        $ex->setType(AMQP_EX_TYPE_DIRECT);
//        $ex->declare();

			// Create a new queue
			$q = new AMQPQueue( $ch );
			$q->setName( 'queue1' );
			$q->declare();

			// Bind it on the exchange to routing.key
			$q->bind( 'new_topic_exchange', 'message.key' );

			// *** *** *** *** *** *** *** ***


			// Read from the queue
			$q->consume( array( "GetTaskCommand", "processMessage" ) );


		}

		public static function processMessage( $envelope, $queue )
		{
			echo "receive!";
			Yii::trace( "receive!" );
			Yii::trace( CVarDumper::dumpAsString( $envelope ) );
		}
	}