<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

//Abre conexão com o RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

//Cria um Channel
$channel = $connection->channel();

//Cria um exchange chamado logs usando o tipo fanout (somente se não existir)
$channel->exchange_declare('logs', 'fanout', false, false, false);

//Solicita a criação de queues temporárias
list($queue_name, ,) = $channel->queue_declare("", false, false, true, false);

//Faz o bing da queue temporária que foi criada com o exchange Logs que criamos
$channel->queue_bind($queue_name, 'logs');

//Printa no console
echo " [*] Waiting for logs. To exit press CTRL+C\n";

//Declara o callback
$callback = function ($msg) {
    echo ' [x] ', $msg->body, "\n";
};

//Declara o "consumer" com o callback
$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

//Fica escutando a fila
while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();