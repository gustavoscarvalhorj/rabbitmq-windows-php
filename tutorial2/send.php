<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//Abre a conexão com o RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

//Cria um channel
$channel = $connection->channel();

//Declara uma queue caso não exista 
$channel->queue_declare('hello', false, false, false, false);

//Pega uma string do console
$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}

//Cria uma mensagem
$msg = new AMQPMessage($data);

//Publica a mensagem
$channel->basic_publish($msg, '', 'hello');

echo ' [x] Sent ', $data, "\n";
$channel->close();
$connection->close();