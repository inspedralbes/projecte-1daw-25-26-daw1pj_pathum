<?php
require_once 'connexio.php';

$idTecnic = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$res = $conn->query("SELECT nom FROM TECNIC WHERE idTecnic = $idTecnic");
$nomTecnic = $res->fetch_assoc()['nom'] ?? "Tècnic";

$resultat = $conn->query("SELECT a.idActuacio, a.descripcio, a.data, a.temps, a.visible, i.idIncidencia
    FROM ACTUACIO a
    JOIN INCIDENCIA i ON a.incidencia = i.idIncidencia
    WHERE i.tecnic = $idTecnic
    ORDER BY a.data DESC");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Actuacions - <?= $nomTecnic ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white">

<?php include 'header.php'; ?>

<div class="container mt-5 mb-5 pb-5" style="max-width: 900px;">

    <h1 class="mb-5 fw-bold text-dark">Taula d'Actuacions</h1>

    <div class="table-responsive shadow-sm rounded border">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>ID Actuació</th>
                    <th>ID Incidència</th>
                    <th>Data</th>
                    <th>Descripció</th>
                    <th>Temps</th>
                    <th>Visible</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultat && $resultat->num_rows > 0): ?>
                    <?php while ($act = $resultat->fetch_assoc()): ?>
                    <tr>
                        <td class="fw-bold">#<?= $act['idActuacio'] ?></td>
                        <td>#<?= $act['idIncidencia'] ?></td>
                        <td><?= date('d/m/Y', strtotime($act['data'])) ?></td>
                        <td><?= htmlspecialchars($act['descripcio']) ?></td>
                        <td><?= $act['temps'] ?> min</td>
                        <td>
                            <?php if($act['visible']): ?>
                                <span class="badge bg-success">Sí</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">No</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">No hi ha actuacions registrades.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="incidencies_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary fw-bold">VOLVER</a>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>