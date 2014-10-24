<?php

	/**
	 * Created by PhpStorm.
	 * User: godson
	 * Date: 25.08.14
	 * Time: 10:44
	 */
	class AddTaskCommand extends CConsoleCommand
	{

		public function run( $args )
		{
			echo "Start add task\n";
			$message     = 'myMessage';
			$exName      = 'exTopic';
			$routingKey1 = 'server1.user.error';
			$routingKey2 = 'server1.pentest.error';
			$routingKey3 = 'server2.user.error';
			//Yii::app()->amqp->exchangeDelete($exName);
			Yii::app()->amqp->declareExchange( $exName, $type = 'topic', $passive = false, $durable = true,
				$auto_delete = false );
			Yii::app()->amqp->publish_message( $message, $exName, $routingKey1, $content_type = '', $app_id = '' );
			Yii::app()->amqp->publish_message( $message, $exName, $routingKey2, $content_type = '', $app_id = '' );
			Yii::app()->amqp->publish_message( $message, $exName, $routingKey3, $content_type = '', $app_id = '' );
			Yii::app()->amqp->closeConnection();
		}

	}