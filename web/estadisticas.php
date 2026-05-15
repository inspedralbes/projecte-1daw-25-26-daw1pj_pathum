<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client("mongodb://root:example@mongo:27017/");
$collection = $client->logs->accessos;

$fecha = $_GET['fecha_filtro'] ?? '';
$filtro = [];
if (!empty($fecha)) {
    $start = new MongoDB\BSON\UTCDateTime(strtotime($fecha) * 1000);
    $end = new MongoDB\BSON\UTCDateTime((strtotime($fecha) + 86400) * 1000);
    $filtro = ['timestamp' => ['$gte' => $start, '$lt' => $end]];
}

$total = $collection->countDocuments($filtro);

$pipelinePagina = [];
if (!empty($filtro)) { $pipelinePagina[] = ['$match' => $filtro]; }
$pipelinePagina[] = ['$group' => ['_id' => '$url', 'visitas' => ['$sum' => 1]]];
$pipelinePagina[] = ['$sort' => ['visitas' => -1]];
$pipelinePagina[] = ['$limit' => 3];

$paginasTop = $collection->aggregate($pipelinePagina)->toArray();

$resGrafico = $collection->aggregate([
    ['$group' => [
        '_id' => ['$dateToString' => ['format' => '%d/%m', 'date' => '$timestamp']],
        'count' => ['$sum' => 1]
    ]],
    ['$sort' => ['_id' => 1]],
    ['$limit' => 7]
])->toArray();

$labels = [];
$valores = [];
foreach ($resGrafico as $v) {
    $labels[] = $v['_id'];
    $valores[] = $v['count'];
}

$accessos = $collection->find($filtro, ['sort' => ['timestamp' => -1], 'limit' => 6]);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Estadístiques - Institut Pedralbes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h4 class="mb-4 fw-bold text-dark">
            <i class="fa-solid fa-chart-line me-2 text-primary"></i>Panell d'estadístiques
        </h4>

        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="p-3 bg-white border rounded shadow-sm h-100 text-center">
                    <small class="text-muted fw-bold">TOTAL ACCESSOS</small>
                    <h3 class="fw-bold text-primary mb-0"><?= $total ?></h3>
                </div>
            </div>

            <div class="col-md-9">
                <div class="p-3 bg-white border rounded shadow-sm h-100">
                    <small class="text-muted text-uppercase fw-bold">Top 3 Pàgines més visitades</small>
                    <div class="d-flex flex-wrap gap-4 mt-2">
                        <?php if (empty($paginasTop)): ?>
                            <p class="text-muted small mb-0">Sense dades registrades.</p>
                        <?php else: ?>
                            <?php foreach ($paginasTop as $index => $p): ?>
                                <div class="border-start ps-3">
                                    <span class="badge bg-dark mb-1"><?= $index + 1 ?>º</span>
                                    <div class="small text-primary fw-bold"><?= htmlspecialchars($p['_id']) ?></div>
                                    <div class="h5 mb-0"><?= $p['visitas'] ?> <small class="text-muted" style="font-size: 0.6em;">visites</small></div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="text-muted mb-3 fw-bold">Tendència d'accessos (Darrers 7 dies)</h6>
                <div style="height: 250px;">
                    <canvas id="meuGrafic"></canvas>
                </div>
            </div>
        </div>

        <form method="GET" class="d-flex gap-2 mb-4">
            <div class="input-group w-25 shadow-sm">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-calendar-days text-muted"></i></span>
                <input type="date" name="fecha_filter" class="form-control border-start-0" value="<?= $fecha ?>">
            </div>
            <button type="submit" class="btn btn-dark px-4 shadow-sm">Filtrar</button>
            <?php if(!empty($fecha)): ?>
                <a href="estadistiques.php" class="btn btn-outline-danger shadow-sm"><i class="fa-solid fa-xmark"></i></a>
            <?php endif; ?>
        </form>

        <div class="table-responsive shadow-sm rounded border">
            <table class="table table-hover bg-white mb-0">
                <thead class="table-primary text-white">
                    <tr>
                        <th>Hora</th>
                        <th>URL</th>
                        <th>Mètode</th>
                        <th>IP del Client</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($total == 0): ?>
                        <tr><td colspan="4" class="text-center py-4 text-muted">No s'han trobat registres per aquesta data.</td></tr>
                    <?php else: ?>
                        <?php foreach ($accessos as $acc): ?>
                        <tr>
                            <td><?= $acc['timestamp']->toDateTime()->format('H:i:s') ?></td>
                            <td class="text-primary fw-bold"><?= htmlspecialchars($acc['url']) ?></td>
                            <td><span class="badge bg-light text-dark border"><?= $acc['method'] ?? 'GET' ?></span></td>
                            <td class="font-monospace small text-muted"><?= $acc['ip'] ?? '127.0.0.1' ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="my-5 pt-3">
            <a href="index.php" class="btn btn-secondary px-4 shadow-sm">VOLVER</a>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('meuGrafic').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Accessos',
                    data: <?= json_encode($valores) ?>,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4, 
                    pointRadius: 5,
                    pointBackgroundColor: '#0d6efd',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { 
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    },
                    x: { 
                        grid: { display: false } 
                    }
                }
            }
        });
    </script>

    <?php include 'footer.php'; ?>

</body>
</html>