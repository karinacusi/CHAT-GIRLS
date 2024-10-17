<?php

require 'vendor/autoload.php';

use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\Server\IoServer;
use App\Controllers\ChatServer;

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    8081 // Puerto para WebSockets
);

echo "Servidor WebSocket corriendo en el puerto 8080...\n";
$server->run();