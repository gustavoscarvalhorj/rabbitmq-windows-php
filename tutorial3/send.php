<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

//Abre uma conexão com o rabbitmq
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

//Cria um channel
$channel = $connection->channel();

//Cria um exchange chamado logs usando o tipo fanout (somente se não existir)
$channel->queue_declare('hello', false, false, false, false);

//Solicita a criação de queues temporárias
$channel->exchange_declare('logs', 'fanout', false, false, false);

//Injeta uma string do console para ser consumida
$data = implode(' ', array_slice($argv, 1));
if (empty($data)) {
    $data = "Hello World!";
}

//Cria uma mensagem
$msg = new AMQPMessage($data);

//Publica a mensagem
$channel->basic_publish($msg, 'logs');

echo ' [x] Sent ', $data, "\n";
$channel->close();
$connection->close();