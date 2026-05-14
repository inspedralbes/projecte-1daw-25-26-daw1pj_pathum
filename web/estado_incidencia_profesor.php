<?php
require_once 'connexio.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($id) {
    $incidencia = $conn->query("SELECT i.idIncidencia, i.data, i.prioritat, i.descripcio, i.dataFinalitzacio,
    d.nom AS departament, tp.nom AS tipus, t.nom AS tecnic
    FROM INCIDENCIA i
    LEFT JOIN DEPARTMENT d ON i.departament = d.idDepartment
    LEFT JOIN TIPO tp ON i.tipo = tp.idTipo
    LEFT JOIN TECNIC t ON i.tecnic = t.idTecnic
    WHERE i.idIncidencia = $id")->fetch_assoc();

    $actuacions = $conn->query("SELECT descripcio, data, temps FROM ACTUACIO 
    WHERE incidencia = $id AND visible = 1 ORDER BY data ASC");
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estat Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

<?php include 'header.php'; ?>

<main class="flex-grow-1 py-4">
    <div class="container mb-5 pb-5">

        <h2 class="mb-4 fw-bold text-dark text-uppercase h3">Estat de la incidència</h2>

        <form method="GET" class="row g-2 mb-4">
            <div class="col-8 col-sm-auto">
                <input type="number" name="id" class="form-control" placeholder="Codi incidència" value="<?= $id ?>">
            </div>
            <div class="col-4 col-sm-auto">
                <button type="submit" class="btn btn-info text-dark fw-bold w-100 shadow-sm">Cercar</button>
            </div>
        </form>

        <?php if (!$id): ?>
            <div class="alert alert-white border text-center py-5 shadow-sm">
                <p class="mb-0 text-muted">Introdueix el codi de la incidència per veure el seu estat.</p>
            </div>

        <?php elseif (!$incidencia): ?>
            <div class="alert alert-warning shadow-sm">No s'ha trobat cap incidència amb aquest codi.</div>

        <?php else: ?>

            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="mb-0 fw-bold">Detalls de la Incidència #<?= $incidencia['idIncidencia'] ?></h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 border-end-md">
                            <p class="mb-2"><strong>Departament:</strong><br> <?= htmlspecialchars($incidencia['departament']) ?></p>
                            <p class="mb-2"><strong>Tipus:</strong><br> <?= htmlspecialchars($incidencia['tipus']) ?></p>
                            <p class="mb-0"><strong>Data obertura:</strong><br> <?= date('d/m/Y', strtotime($incidencia['data'])) ?></p>
                        </div>
                        <hr class="d-md-none">
                        <div class="col-12 col-md-6">
                            <p class="mb-2"><strong>Tècnic:</strong><br> <?= htmlspecialchars($incidencia['tecnic'] ?? 'Sense assignar') ?></p>
                            <p class="mb-2"><strong>Prioritat:</strong><br> <?= $incidencia['prioritat'] ?: 'Sense assignar' ?></p>
                            <p class="mb-2"><strong>Estat:</strong><br>
                                <?php if(is_null($incidencia['dataFinalitzacio'])): ?>
                                    <span class="badge bg-warning text-dark px-3 shadow-sm">Pendent</span>
                                <?php else: ?>
                                    <span class="badge bg-success px-3 shadow-sm">Finalitzada</span>
                                <?php endif; ?>
                            </p>
                        </div>
                        <div class="col-12 mt-3 p-3 bg-light rounded border">
                            <strong>Descripció del problema:</strong><br>
                            <span class="small"><?= htmlspecialchars($incidencia['descripcio']) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mb-3 fw-bold h5 text-uppercase">Actuacions realitzades</h4>
            <?php if ($actuacions->num_rows > 0): ?>
                <div class="table-responsive shadow-sm rounded border">
                    <table class="table table-secondary table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr class="small text-uppercase">
                                <th class="py-3">Data</th>
                                <th class="py-3">Descripció</th>
                                <th class="py-3 text-nowrap">Temps</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($act = $actuacions->fetch_assoc()): ?>
                            <tr>
                                <td class="text-nowrap small"><?= date('d/m/Y', strtotime($act['data'])) ?></td>
                                <td class="small"><?= htmlspecialchars($act['descripcio']) ?></td>
                                <td class="text-nowrap fw-bold"><?= $act['temps'] ?> <small>min</small></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-light border text-center shadow-sm">Encara no hi ha actuacions visibles.</div>
            <?php endif; ?>

        <?php endif; ?>

        <div class="d-flex flex-column flex-sm-row justify-content-between gap-3 mt-5">
            <a href="index.php" class="btn btn-secondary px-4 py-2 fw-bold text-uppercase shadow-sm">Inici</a>
            <a href="interfaz_incidencias_profesor.php" class="btn btn-secondary px-4 py-2 fw-bold text-uppercase shadow-sm">Volver</a>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>

</body>
</html>