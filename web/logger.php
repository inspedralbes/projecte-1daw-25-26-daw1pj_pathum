<?php
require_once __DIR__ . '/vendor/autoload.php';

function registrarLog() {
    try {
        $uri = getenv('MONGODB_URI') ?: "mongodb://root:example@mongo:27017/";
        $client = new MongoDB\Client($uri);
        $collection = $client->logs->accessos;

        $collection->insertOne([
            'url'       => $_SERVER['REQUEST_URI'] ?? '',
            'method'    => $_SERVER['REQUEST_METHOD'] ?? '',
            'ip'        => $_SERVER['REMOTE_ADDR'] ?? '',
            'navegador' => $_SERVER['HTTP_USER_AGENT'] ?? 'Desconegut',
            'usuari'    => null, 
            'timestamp' => new MongoDB\BSON\UTCDateTime()
        ]);
    } catch (Exception $e) {
        
    }
}
registrarLog();