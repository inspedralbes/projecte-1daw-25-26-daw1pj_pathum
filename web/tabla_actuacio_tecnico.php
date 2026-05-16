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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actuacions - <?= $nomTecnic ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white d-flex flex-column min-vh-100">

<?php include 'header.php'; ?>

<main class="flex-grow-1 py-4">
    <div class="container" style="max-width: 900px;">

        <h1 class="mb-4 fw-bold text-dark h2 text-uppercase">Taula d'Actuacions</h1>
        <h5 class="text-muted mb-4 small text-uppercase">Historial de: <?= htmlspecialchars($nomTecnic) ?></h5>

        <div class="table-responsive shadow-sm rounded border">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th class="py-3">ID Act.</th>
                        <th class="py-3">ID Inc.</th>
                        <th class="py-3">Data</th>
                        <th class="py-3">Descripció</th>
                        <th class="py-3 text-nowrap">Temps</th>
                        <th class="py-3">Visible</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($resultat && $resultat->num_rows > 0): ?>
                        <?php while ($act = $resultat->fetch_assoc()): ?>
                        <tr>
                            <td class="fw-bold">#<?= $act['idActuacio'] ?></td>
                            <td class="text-muted">#<?= $act['idIncidencia'] ?></td>
                            <td style="white-space: nowrap;"><?= date('d/m/Y', strtotime($act['data'])) ?></td>
                            <td class="text-start small"><?= htmlspecialchars($act['descripcio']) ?></td>
                            <td class="text-nowrap"><?= $act['temps'] ?> min</td>
                            <td>
                                <?php if($act['visible']): ?>
                                    <span class="badge bg-success shadow-sm">Sí</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary shadow-sm">No</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted small">No hi ha actuacions registrades.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5 mb-5 text-center text-md-start">
            <a href="incidencies_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary px-5 py-2 fw-bold text-uppercase shadow-sm">Volver</a>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>