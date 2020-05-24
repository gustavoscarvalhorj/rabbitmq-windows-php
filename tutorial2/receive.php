<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

//Abre a conexão com o RabbitMQ
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');

//Cria um channel
$channel = $connection->channel();

//Declara uma queue chamad 'hello' caso não exista 
$channel->queue_declare('hello', false, false, false, false);

//Exibe no console que está escutando a fila
echo " [*] Waiting for messages. To exit press CTRL+C\n";

//Cria um callback para receber a mensagem
$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
    sleep(substr_count($msg->body, '.'));
    echo " [x] Done\n";
    $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
  };
  
//Declara um consumidor que fica escutando a queue "hello";  
$channel->basic_consume('hello', '', false, false, false, false, $callback);

//Escuta a fila
while ($channel->is_consuming()) {
    $channel->wait();
}

//Fecha o channel e a connection
$channel->close();
$connection->close();