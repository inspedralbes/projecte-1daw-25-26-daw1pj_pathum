<?php
require_once __DIR__ . '/vendor/autoload.php';

$client = new MongoDB\Client("mongodb://root:example@mongo:27017/");
$collection = $client->logs->accessos;

$fechaFiltro = $_GET['fecha_filtro'] ?? '';
$logsBase = $collection->find()->toArray() ?: [];

$total = 0;
$conteoPaginas = [];
$conteoPorDia = []; 
$logsFiltrados = [];

foreach ($logsBase as $registro) {
    $fechaCompleta = $registro['timestamp']->toDateTime()->format('Y-m-d');
    $fechaGrafico = $registro['timestamp']->toDateTime()->format('d/m');

    if (!isset($conteoPorDia[$fechaGrafico])) { 
        $conteoPorDia[$fechaGrafico] = 0; 
    }
    $conteoPorDia[$fechaGrafico]++;

    if (empty($fechaFiltro) || $fechaFiltro == $fechaCompleta) {
        $total++;
        $logsFiltrados[] = $registro;

        $url = $registro['url'] ?? 'Desconeguda';
        if (!isset($conteoPaginas[$url])) { $conteoPaginas[$url] = 0; }
        $conteoPaginas[$url]++;
    }
}

arsort($conteoPaginas);
$top3 = array_slice($conteoPaginas, 0, 3, true);

$labelsGrafico = array_keys($conteoPorDia);
$datosGrafico = array_values($conteoPorDia);

$ultimsLogs = array_slice(array_reverse($logsFiltrados), 0, 6);
?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Estadístiques - Institut Pedralbes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container mt-4">
        <h2 class="mb-4 fw-bold">Panell d'Estadístiques</h2>

        <form method="GET" class="d-flex gap-2 mb-4">
            <input type="date" name="fecha_filtro" class="form-control w-25 shadow-sm" value="<?= htmlspecialchars($fechaFiltro) ?>">
            <button type="submit" class="btn btn-dark px-4">Filtrar</button>
            <?php if(!empty($fechaFiltro)): ?>
                <a href="estadisticas.php" class="btn btn-outline-danger">Netejar</a>
            <?php endif; ?>
        </form>

        <div class="row mb-4 g-3">
            <div class="col-md-4">
                <div class="card p-3 shadow-sm text-center border-0">
                    <span class="text-muted small fw-bold">TOTAL VISITES</span>
                    <h1 class="display-4 fw-bold text-primary"><?= $total ?></h1>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card p-3 shadow-sm border-0">
                    <span class="text-muted small fw-bold mb-2">PÀGINES MÉS VISITADES</span>
                    <?php if(empty($top3)): ?>
                        <p class="text-muted small">Sense dades.</p>
                    <?php else: ?>
                        <?php foreach ($top3 as $url => $visitas): ?>
                            <div class="d-flex justify-content-between border-bottom py-2">
                                <span class="text-truncate" style="max-width: 85%;"><?= htmlspecialchars($url) ?></span>
                                <span class="badge bg-primary rounded-pill d-flex align-items-center"><?= $visitas ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="card p-4 shadow-sm border-0 mb-4">
            <div style="height: 250px;">
                <canvas id="graficSimple"></canvas>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover bg-white shadow-sm border">
                <thead class="table-dark">
                    <tr>
                        <th>Hora</th>
                        <th>Mètode</th> 
                        <th>URL</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($ultimsLogs)): ?>
                        <?php foreach ($ultimsLogs as $l): ?>
                        <tr>
                            <td class="small"><?= $l['timestamp']->toDateTime()->format('H:i:s') ?></td>
                            <td>
                                <span class="badge bg-light text-dark border">
                                    <?= htmlspecialchars($l['method'] ?? 'GET') ?>
                                </span>
                            </td>
                            <td class="text-primary fw-bold"><?= htmlspecialchars($l['url'] ?? '-') ?></td>
                            <td class="font-monospace small text-muted"><?= htmlspecialchars($l['ip'] ?? '127.0.0.1') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" class="text-center py-4 text-muted">No hi ha dades per aquesta data.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="my-5 pt-4">
            <a href="index.php" class="btn btn-secondary px-4 shadow-sm">TORNA A INICI</a>
        </div>
    </div>

    <script>
        new Chart(document.getElementById('graficSimple'), {
            type: 'line',
            data: {
                labels: <?= json_encode($labelsGrafico) ?>,
                datasets: [{
                    label: 'Visites totals per dia',
                    data: <?= json_encode($datosGrafico) ?>,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                }
            }
        });
    </script>

    <?php include 'footer.php'; ?>
</body>
</html>