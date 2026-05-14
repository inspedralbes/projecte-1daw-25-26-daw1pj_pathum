<?php
require_once __DIR__ . '/vendor/autoload.php';

function registrarLog() {
    try {
        $client = new MongoDB\Client("mongodb://root:example@mongo:27017/");
        $collection = $client->logs->accessos;

        $collection->insertOne([
            'url'       => $_SERVER['REQUEST_URI'] ?? '',
            'metode'    => $_SERVER['REQUEST_METHOD'] ?? '',
            'ip'        => $_SERVER['REMOTE_ADDR'] ?? '',
            'navegador' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'usuari'    => null,
            'timestamp' => new MongoDB\BSON\UTCDateTime()
        ]);
    } catch (Exception $e) {
        // Si falla MongoDB no aturem la web
    }
}

registrarLog();