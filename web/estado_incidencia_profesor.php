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
    <title>Estat Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container mt-4 mb-5 pb-5">

    <h2 class="mb-4">Estat de la incidència</h2>

    <form method="GET" class="d-flex gap-2 mb-4">
        <input type="number" name="id" class="form-control w-auto" placeholder="Introdueix el codi de la incidència" value="<?= $id ?>">
        <button type="submit" class="btn btn-info text-white">Cercar</button>
    </form>

    <?php if (!$id): ?>
        <div class="alert alert-light border text-center py-4">
            Introdueix el codi de la incidència per veure el seu estat.
        </div>

    <?php elseif (!$incidencia): ?>
        <div class="alert alert-warning">No s'ha trobat cap incidència amb aquest codi.</div>

    <?php else: ?>

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> #<?= $incidencia['idIncidencia'] ?></p>
                        <p><strong>Departament:</strong> <?= $incidencia['departament'] ?></p>
                        <p><strong>Tipus:</strong> <?= $incidencia['tipus'] ?></p>
                        <p><strong>Data obertura:</strong> <?= date('d/m/Y', strtotime($incidencia['data'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tècnic:</strong> <?= $incidencia['tecnic'] ?? 'Sense assignar' ?></p>
                        <p><strong>Prioritat:</strong> <?= $incidencia['prioritat'] ?: 'Sense assignar' ?></p>
                        <p><strong>Descripció:</strong> <?= $incidencia['descripcio'] ?></p>
                        <p><strong>Estat:</strong>
                            <?php if(is_null($incidencia['dataFinalitzacio'])): ?>
                                <span class="badge bg-warning text-dark">Pendent</span>
                            <?php else: ?>
                                <span class="badge bg-success">Finalitzada</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-3">Actuacions</h4>
        <?php if ($actuacions->num_rows > 0): ?>
            <div class="table-responsive shadow-sm rounded">
                <table class="table table-secondary table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Data</th>
                            <th>Descripció</th>
                            <th>Temps</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($act = $actuacions->fetch_assoc()): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($act['data'])) ?></td>
                            <td><?= htmlspecialchars($act['descripcio']) ?></td>
                            <td><?= $act['temps'] ?> min</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-light border text-center">Encara no hi ha actuacions visibles.</div>
        <?php endif; ?>

    <?php endif; ?>

    <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary">INICI</a>
        <a href="interfaz_incidencias_profesor.php" class="btn btn-secondary">VOLVER</a>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>