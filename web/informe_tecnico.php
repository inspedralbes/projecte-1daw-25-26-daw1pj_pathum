<?php
require_once 'connexio.php';

$result = $conn->query("
    SELECT 
        t.nom AS tecnic,
        i.idIncidencia,
        i.descripcio,
        i.data,
        i.prioritat,
        SUM(a.temps) AS temps_total
    FROM TECNIC t
    JOIN INCIDENCIA i ON i.tecnic = t.idTecnic
    LEFT JOIN ACTUACIO a ON a.incidencia = i.idIncidencia
    WHERE i.dataFinalitzacio IS NULL
    GROUP BY t.idTecnic, t.nom, i.idIncidencia, i.descripcio, i.data, i.prioritat
    ORDER BY t.nom, FIELD(i.prioritat, 'Alta', 'Mitja', 'Baixa')
");

$dades = [];
while ($row = $result->fetch_assoc()) {
    $dades[$row['tecnic']][$row['prioritat']][] = $row;
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informe de Tècnics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php include 'header.php'; ?>

<main class="flex-grow-1 py-4">
    <div class="container mb-5 pb-5">

        <h2 class="mb-4 fw-bold text-dark text-uppercase h3">Informe de Tècnics</h2>

        <?php foreach ($dades as $nomTecnic => $prioritats): ?>
            <div class="card shadow-sm mb-5 border-0">
                <div class="card-header bg-dark text-white fw-bold fs-5 py-3">
                    <i class="bi bi-person-badge me-2"></i><?= htmlspecialchars($nomTecnic) ?>
                </div>
                <div class="card-body p-3 p-md-4">
                    <?php foreach (['Alta', 'Mitja', 'Baixa'] as $prioritat): ?>
                        <?php if (isset($prioritats[$prioritat])): ?>
                            <h6 class="fw-bold mt-3 mb-3">
                                <?php
                                $badgeClass = match($prioritat) {
                                    'Alta'  => 'bg-danger',
                                    'Mitja' => 'bg-warning text-dark',
                                    'Baixa' => 'bg-info text-dark'
                                };
                                ?>
                                <span class="badge <?= $badgeClass ?> px-3 py-2 text-uppercase"><?= $prioritat ?></span>
                            </h6>
                            
                            <div class="table-responsive rounded-3 mb-4">
                                <table class="table table-hover align-middle border shadow-sm">
                                    <thead class="table-secondary">
                                        <tr class="small text-uppercase">
                                            <th class="py-3">ID</th>
                                            <th class="py-3">Descripció</th>
                                            <th class="py-3 text-nowrap">Data inici</th>
                                            <th class="py-3 text-nowrap">Temps total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($prioritats[$prioritat] as $inc): ?>
                                        <tr>
                                            <td class="fw-bold">#<?= $inc['idIncidencia'] ?></td>
                                            <td class="small"><?= htmlspecialchars($inc['descripcio']) ?></td>
                                            <td class="text-nowrap small"><?= date('d/m/Y', strtotime($inc['data'])) ?></td>
                                            <td class="text-nowrap fw-bold text-primary"><?= $inc['temps_total'] ?? 0 ?> <small>min</small></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($dades)): ?>
            <div class="alert alert-white border shadow-sm text-center py-5">
                <p class="mb-0 text-muted fw-bold">No hi ha incidències pendents en aquest moment.</p>
            </div>
        <?php endif; ?>

        <div class="row g-3 mt-4">
            <div class="col-12 col-sm-6 col-md-3">
                <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase">Inici</a>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <a href="listado_incidencias_admin.php" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase">Tornar</a>
            </div>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>