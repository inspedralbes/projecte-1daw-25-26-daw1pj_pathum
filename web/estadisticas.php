<?php
require_once __DIR__ . '/vendor/autoload.php';

// 1. Conexión básica
$client = new MongoDB\Client("mongodb://root:example@mongo:27017/");
$collection = $client->logs->accessos;

// 2. Mirar si hay fecha. Si no hay, el filtro es un array vacío.
$fecha = $_GET['fecha_filtro'] ?? '';
$filtro = [];

if (!empty($fecha)) {
    $start = new MongoDB\BSON\UTCDateTime(strtotime($fecha) * 1000);
    $end = new MongoDB\BSON\UTCDateTime((strtotime($fecha) + 86400) * 1000);
    $filtro = ['timestamp' => ['$gte' => $start, '$lt' => $end]];
}

// --- AGREGACIONES (Paso a paso para que no pete) ---

// Total de accesos (Sencillo)
$total = $collection->countDocuments($filtro);

// Página más visitada (Solo si hay datos, para no complicar con objetos)
$pipelinePagina = [];
if (!empty($filtro)) { $pipelinePagina[] = ['$match' => $filtro]; }
$pipelinePagina[] = ['$group' => ['_id' => '$url', 'visitas' => ['$sum' => 1]]];
$pipelinePagina[] = ['$sort' => ['visitas' => -1]];
$pipelinePagina[] = ['$limit' => 1];

$resPagina = $collection->aggregate($pipelinePagina)->toArray();
$paginaTop = $resPagina[0]['_id'] ?? 'Cap';

// Navegador más usado (Igual de simple)
$pipelineNav = [];
if (!empty($filtro)) { $pipelineNav[] = ['$match' => $filtro]; }
$pipelineNav[] = ['$group' => ['_id' => '$navegador', 'votos' => ['$sum' => 1]]];
$pipelineNav[] = ['$sort' => ['votos' => -1]];
$pipelineNav[] = ['$limit' => 1];

$resNav = $collection->aggregate($pipelineNav)->toArray();
$navTop = $resNav[0]['_id'] ?? 'Cap';

// Tabla de los últimos 6
$accessos = $collection->find($filtro, ['sort' => ['timestamp' => -1], 'limit' => 6]);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="p-3 bg-white border rounded shadow-sm">
                    <small class="text-muted">TOTAL ACCESOS</small>
                    <h3 class="fw-bold"><?= $total ?></h3>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-white border rounded shadow-sm">
                    <small class="text-muted">PÀGINA TOP</small>
                    <p class="mb-0 text-truncate"><strong><?= $paginaTop ?></strong></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3 bg-white border rounded shadow-sm">
                    <small class="text-muted">NAVEGADOR TOP</small>
                    <p class="mb-0 text-truncate"><strong><?= substr($navTop, 0, 20) ?>...</strong></p>
                </div>
            </div>
        </div>

        <form method="GET" class="d-flex gap-2 mb-4">
            <input type="date" name="fecha_filtro" class="form-control w-25" value="<?= $fecha ?>">
            <button type="submit" class="btn btn-secondary">Filtrar</button>
            <a href="estadistiques.php" class="btn btn-outline-danger">X</a>
        </form>

        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-secondary">
                <tr><th>Hora</th><th>URL</th><th>Mètode</th></tr>
            </thead>
            <tbody>
                <?php foreach ($accessos as $acc): ?>
                <tr>
                    <td><?= $acc['timestamp']->toDateTime()->format('H:i:s') ?></td>
                    <td><?= $acc['url'] ?></td>
                    <td><span class="badge bg-light text-dark border"><?= $acc['method'] ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <a href="listado_incidencias_admin.php" class="btn btn-secondary mt-3">VOLVER</a>
    </div>
</body>
</html>