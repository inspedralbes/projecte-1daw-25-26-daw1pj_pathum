<?php
// Cargamos las librerías
require_once __DIR__ . '/vendor/autoload.php';

try {
    // Conexión básica
    $client = new MongoDB\Client("mongodb://root:example@mongo:27017/");
    $collection = $client->logs->accessos;

    // Preparamos el documento con lo que pide el enunciado
    $documento = [
        'url'       => $_SERVER['REQUEST_URI'],
        'metode'    => $_SERVER['REQUEST_METHOD'],
        'usuari'    => $_SESSION['usuari'] ?? null, // Si no hay sesión, guarda null
        'timestamp' => new MongoDB\BSON\UTCDateTime(),
        'navegador' => $_SERVER['HTTP_USER_AGENT'],
        'ip'        => $_SERVER['REMOTE_ADDR']
    ];

    // Insertamos
    $collection->insertOne($documento);

} catch (Exception $e) {
    // Si falla, que no haga nada para no romper la web
}
?>