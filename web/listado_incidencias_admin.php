<?php

require_once 'connexio.php'; 
require_once __DIR__ . '/vendor/autoload.php'; 


try {
    $mongoClient = new MongoDB\Client("mongodb://root:example@mongo:27017/");
    $logCollection = $mongoClient->logs->accessos;
    $totalLogs = $logCollection->countDocuments();
} catch (Exception $e) {
    $totalLogs = 0;
}


$idBusqueda = isset($_GET['id_busqueda']) ? $conn->real_escape_string($_GET['id_busqueda']) : '';
$sql = "
    SELECT 
        i.idIncidencia,
        i.descripcio,
        i.data,
        i.prioritat,
        i.dataFinalitzacio,
        d.nom AS departament,
        t.nom AS tecnic,
        tp.nom AS tipus
    FROM INCIDENCIA i
    LEFT JOIN DEPARTMENT d  ON i.departament = d.idDepartment
    LEFT JOIN TECNIC t      ON i.tecnic = t.idTecnic
    LEFT JOIN TIPO tp       ON i.tipo = tp.idTipo";
if (!empty($idBusqueda)) {
    $sql .= " WHERE i.idIncidencia = '$idBusqueda' AND i.dataFinalitzacio IS NULL";
} else {
    $sql .= " WHERE i.dataFinalitzacio IS NULL";
}
$sql .= " ORDER BY i.data DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestió d'Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container mt-5 mb-5 pb-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Llistat d'Incidències</h2>
        
        <div class="d-flex gap-2">
            <a href="lista_logs.php" class="btn btn-info d-flex align-items-center gap-2 text-white">
                <i class="bi bi-bar-chart-line-fill"></i> 
                <span class="badge bg-white text-info"><?= $totalLogs ?></span>
            </a>

            <form action="" method="GET" class="d-flex gap-2">
                <input type="number" name="id_busqueda" class="form-control" placeholder="Cerca per ID..." value="<?= htmlspecialchars($idBusqueda) ?>">
                <button type="submit" class="btn btn-primary">Cercar</button>
                <?php if(!empty($idBusqueda)): ?>
                    <a href="?" class="btn btn-outline-secondary">Veure totes</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-secondary table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Descripció</th>
                    <th>Departament</th>
                    <th>Tipus</th>
                    <th>Tècnic</th>
                    <th>Prioritat</th>
                    <th>Data</th>
                    <th>Estat</th>
                    <th>Acció</th>
                    <th>Actuacions internes</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                        $estat = is_null($row['dataFinalitzacio']) ? 'Pendent' : 'Finalitzada';
                        $badgeClass = $estat === 'Pendent' ? 'bg-warning text-dark' : 'bg-success';
                        $prioritatClass = match($row['prioritat']) {
                            'Alta'  => 'bg-danger',
                            'Mitja' => 'bg-warning text-dark',
                            'Baixa' => 'bg-info text-dark',
                            default => 'bg-secondary'
                        };
                        $actuacionsInternes = $conn->query("SELECT descripcio, data, temps FROM ACTUACIO 
                            WHERE incidencia = " . $row['idIncidencia'] . " AND visible = 0");
                    ?>
                    <tr>
                        <td><strong>#<?= $row['idIncidencia'] ?></strong></td>
                        <td><?= htmlspecialchars($row['descripcio'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['departament'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['tipus'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['tecnic'] ?? 'Sense assignar') ?></td>
                        <td><span class="badge <?= $prioritatClass ?>"><?= $row['prioritat'] ?></span></td>
                        <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                        <td><span class="badge <?= $badgeClass ?>"><?= $estat ?></span></td>
                        <td><a href="asignar_incidencia.php?id=<?= $row['idIncidencia'] ?>" class="btn btn-sm btn-outline-primary">Gestionar</a></td>
                        <td>
                            <?php if ($actuacionsInternes->num_rows > 0): ?>
                                <?php while ($act = $actuacionsInternes->fetch_assoc()): ?>
                                    <div class="mb-1">
                                        <small>
                                            <strong><?= date('d/m/Y', strtotime($act['data'])) ?></strong>
                                            — <?= $act['descripcio'] ?> (<?= $act['temps'] ?> min)
                                        </small>
                                    </div>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <small class="text-muted">—</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">No s'ha trobat cap incidència.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4 d-flex gap-2">
        <a href="index.php" class="btn btn-secondary">Inici</a>
        <a href="informe_tecnico.php" class="btn btn-secondary">Informe Tècnics</a>
        <a href="departamento_tecnico.php" class="btn btn-secondary">Consum Departaments</a>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>