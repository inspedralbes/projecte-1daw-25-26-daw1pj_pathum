<?php
require_once 'connexio.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;


$sql = "SELECT i.idIncidencia, i.data, i.prioritat, i.descripcio, 
        d.nom AS departament, tp.nom AS tipus, t.nom AS tecnic
        FROM INCIDENCIA i
        LEFT JOIN DEPARTMENT d ON i.departament = d.idDepartment
        LEFT JOIN TIPO tp ON i.tipo = tp.idTipo
        LEFT JOIN TECNIC t ON i.tecnic = t.idTecnic";

if ($id) {
    $sql .= " WHERE i.idIncidencia = $id";
}
$result = $conn->query($sql);
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

<div class="container py-4 flex-grow-1">

    <h2 class="mb-4 fw-bold text-dark text-uppercase">Estat de les incidències</h2>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-12 col-md-4">
            <input type="number" name="id" class="form-control" placeholder="Cerca per ID" value="<?= $id ?>">
        </div>
        <div class="col-6 col-md-auto">
            <button type="submit" class="btn btn-info text-dark fw-bold w-100">Cercar</button>
        </div>
        <div class="col-6 col-md-auto">
            <a href="estado_incidencia_profesor.php" class="btn btn-secondary fw-bold w-100">Veure totes</a>
        </div>
    </form>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover bg-white mb-0">
            <thead class="table-dark text-uppercase small">
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Dept.</th>
                    <th>Tipus</th>
                    <th>Tècnic</th>
                    <th>Prio.</th>
                    <th>Descripció</th>
                    <th>Actuacions</th>
                </tr>
            </thead>
            <tbody class="align-middle">
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                        $actuacions = $conn->query("SELECT descripcio, data, temps FROM ACTUACIO 
                            WHERE incidencia = " . $row['idIncidencia'] . " AND visible = 1");
                    ?>
                    <tr>
                        <td class="fw-bold">#<?= $row['idIncidencia'] ?></td>
                        <td style="min-width: 100px;"><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                        <td><span class="badge bg-light text-dark border"><?= $row['departament'] ?></span></td>
                        <td><?= $row['tipus'] ?></td>
                        <td class="text-secondary small"><?= $row['tecnic'] ?? 'Pendent' ?></td>
                        <td>
                            <span class="small fw-bold"><?= $row['prioritat'] ?: '-' ?></span>
                        </td>
                        <td style="min-width: 200px;"><?= htmlspecialchars($row['descripcio']) ?></td>
                        <td style="min-width: 250px;">
                            <?php if ($actuacions->num_rows > 0): ?>
                                <?php while ($act = $actuacions->fetch_assoc()): ?>
                                    <div class="p-2 border-bottom extra-small bg-light mb-1 rounded">
                                        <div class="d-flex justify-content-between">
                                            <strong style="font-size: 0.75rem;"><?= date('d/m/Y', strtotime($act['data'])) ?></strong>
                                            <span class="badge bg-secondary"><?= $act['temps'] ?> min</span>
                                        </div>
                                        <div class="text-muted small"><?= htmlspecialchars($act['descripcio']) ?></div>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <span class="text-muted small italic">Sense actuacions</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">No hi ha incidències per mostrar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="row g-2 mt-4 mb-5">
        <div class="col-6 col-md-3">
            <a href="index.php" class="btn btn-secondary w-100 fw-bold shadow-sm">INICI</a>
        </div>
        <div class="col-6 col-md-3">
            <a href="interfaz_incidencias_profesor.php" class="btn btn-secondary w-100 fw-bold shadow-sm">VOLVER</a>
        </div>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>