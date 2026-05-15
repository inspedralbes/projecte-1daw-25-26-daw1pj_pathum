<?php

require_once __DIR__ . '/vendor/autoload.php';

try {
    
    $client = new MongoDB\Client("mongodb://root:example@mongo:27017/");
    $collection = $client->logs->accessos;

   
    $documento = [
        'url'       => $_SERVER['REQUEST_URI'],
        'metode'    => $_SERVER['REQUEST_METHOD'],
        'usuari'    => $_SESSION['usuari'] ?? null, 
        'timestamp' => new MongoDB\BSON\UTCDateTime(),
        'navegador' => $_SERVER['HTTP_USER_AGENT'],
        'ip'        => $_SERVER['REMOTE_ADDR']
    ];

    
    $collection->insertOne($documento);

} catch (Exception $e) {
    
}
?>