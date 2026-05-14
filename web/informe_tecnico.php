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
    <title>Informe de Tècnics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container mt-4 mb-5 pb-5">

    <h2 class="mb-4">Informe de Tècnics</h2>

    <?php foreach ($dades as $nomTecnic => $prioritats): ?>
        <div class="card shadow-sm mb-4">
            <div class="card-header fw-bold fs-5">
                <?= htmlspecialchars($nomTecnic) ?>
            </div>
            <div class="card-body">
                <?php foreach (['Alta', 'Mitja', 'Baixa'] as $prioritat): ?>
                    <?php if (isset($prioritats[$prioritat])): ?>
                        <h6 class="fw-bold mt-3">
                            <?php
                            $badgeClass = match($prioritat) {
                                'Alta'  => 'bg-danger',
                                'Mitja' => 'bg-warning text-dark',
                                'Baixa' => 'bg-info text-dark'
                            };
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= $prioritat ?></span>
                        </h6>
                        <table class="table table-secondary table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Descripció</th>
                                    <th>Data inici</th>
                                    <th>Temps total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($prioritats[$prioritat] as $inc): ?>
                                <tr>
                                    <td>#<?= $inc['idIncidencia'] ?></td>
                                    <td><?= htmlspecialchars($inc['descripcio']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($inc['data'])) ?></td>
                                    <td><?= $inc['temps_total'] ?? 0 ?> min</td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if (empty($dades)): ?>
        <div class="alert alert-light border text-center">No hi ha incidències pendents.</div>
    <?php endif; ?>

    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">INICI</a>
        <a href="listado_incidencias_admin.php" class="btn btn-secondary">TORNAR</a>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>