<?php
// Cargamos las librerías de MongoDB
require_once __DIR__ . '/vendor/autoload.php';

try {
    // Conexión a la base de datos
    $client = new MongoDB\Client("mongodb://root:example@mongo:27017/");
    $collection = $client->logs->accessos;

    // Buscamos los logs: Ordenados por los más recientes (-1) y limitados a 10
    $accessos = $collection->find([], [
        'sort' => ['timestamp' => -1],
        'limit' => 10
    ]);
    
    // Contamos el total para el badge azul
    $total = $collection->countDocuments();
} catch (Exception $e) {
    die("Error connectant a MongoDB: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logs d'Accés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Registre d'Accessos (MongoDB)</h2>
        <span class="badge bg-primary fs-6">Total: <?= $total ?> visitas</span>
    </div>

    <div class="table-responsive shadow-sm rounded border bg-white">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Data i Hora</th>
                    <th>Pàgina (URL)</th>
                    <th>IP del Client</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accessos as $acc): ?>
                <tr>
                    <td>
                        <?php 
                            if (isset($acc['timestamp'])) {
                                // Convertimos a objeto DateTime de PHP
                                $date = $acc['timestamp']->toDateTime();
                                
                                // Ajustamos a la zona horaria local (España)
                                $date->setTimezone(new DateTimeZone('Europe/Madrid'));
                                
                                echo $date->format('d/m/Y H:i:s');
                            } else {
                                echo "N/A";
                            }
                        ?>
                    </td>
                    <td class="text-primary font-monospace"><?= htmlspecialchars($acc['url'] ?? '/') ?></td>
                    <td><small class="text-muted"><?= htmlspecialchars($acc['ip'] ?? '127.0.0.1') ?></small></td>
                </tr>
                <?php endforeach; ?>
                
                <?php if($total == 0): ?>
                    <tr><td colspan="3" class="text-center py-4 text-muted">No hi ha registres en la col·lecció 'accessos'.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="javascript:history.back()" class="btn btn-secondary px-4">VOLVER</a>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>