<?php
require_once 'connexio.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
if ($id) {
    $result = $conn->query("SELECT i.idIncidencia, i.data, i.prioritat, i.descripcio, i.dataFinalitzacio,
    d.nom AS departament, tp.nom AS tipus, t.nom AS tecnic
    FROM INCIDENCIA i
    LEFT JOIN DEPARTMENT d ON i.departament = d.idDepartment
    LEFT JOIN TIPO tp ON i.tipo = tp.idTipo
    LEFT JOIN TECNIC t ON i.tecnic = t.idTecnic
    WHERE i.idIncidencia = $id");
} else {
    $result = $conn->query("SELECT i.idIncidencia, i.data, i.prioritat, i.descripcio, i.dataFinalitzacio,
    d.nom AS departament, tp.nom AS tipus, t.nom AS tecnic
    FROM INCIDENCIA i
    LEFT JOIN DEPARTMENT d ON i.departament = d.idDepartment
    LEFT JOIN TIPO tp ON i.tipo = tp.idTipo
    LEFT JOIN TECNIC t ON i.tecnic = t.idTecnic");
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

    <h2 class="mb-4">Estat de les incidències</h2>

    <form method="GET" class="d-flex gap-2 mb-4">
        <input type="number" name="id" class="form-control w-auto" placeholder="Cerca per ID" value="<?= $id ?>">
        <button type="submit" class="btn btn-info text-white">Cercar</button>
        <a href="estado_incidencia_profesor.php" class="btn btn-secondary">Veure totes</a>
    </form>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-secondary table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Departament</th>
                    <th>Tipus</th>
                    <th>Tècnic</th>
                    <th>Prioritat</th>
                    <th>Descripció</th>
                    <th>Actuacions</th>
                    <th>Estat</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                    $actuacions = $conn->query("SELECT descripcio, data, temps FROM ACTUACIO 
                    WHERE incidencia = " . $row['idIncidencia'] . " AND visible = 1");
                ?>
                <tr>
                    <td><?= $row['idIncidencia'] ?></td>
                    <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                    <td><?= $row['departament'] ?></td>
                    <td><?= $row['tipus'] ?></td>
                    <td><?= $row['tecnic'] ?? 'Sense assignar' ?></td>
                    <td><?= $row['prioritat'] ?: 'Sense assignar' ?></td>
                    <td><?= $row['descripcio'] ?></td>
                    <td>
                        <?php if ($actuacions->num_rows > 0): ?>
                            <?php while ($act = $actuacions->fetch_assoc()): ?>
                                <div class="mb-1">
                                    <small>
                                        <strong><?= date('d/m/Y', strtotime($act['data'])) ?></strong>
                                        — <?= $act['descripcio'] ?> (<?= $act['temps'] ?> min)
                                    </small>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <small class="text-muted">Sense actuacions</small>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(is_null($row['dataFinalitzacio'])): ?>
                            <span class="badge bg-warning text-dark">Pendent</span>
                        <?php else: ?>
                            <span class="badge bg-success">Finalitzada</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary">INICI</a>
        <a href="interfaz_incidencias_profesor.php" class="btn btn-secondary">VOLVER</a>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>