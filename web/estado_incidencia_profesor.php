<?php
require_once 'connexio.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($id) {
    $result = $conn->query("SELECT i.idIncidencia, i.data, i.prioritat, i.descripcio, d.nom AS departament, tp.nom AS tipus, t.nom AS tecnic
    FROM INCIDENCIA i
    LEFT JOIN DEPARTMENT d ON i.departament = d.idDepartment
    LEFT JOIN TIPO tp ON i.tipo = tp.idTipo
    LEFT JOIN TECNIC t ON i.tecnic = t.idTecnic
    WHERE i.idIncidencia = $id");
} else {
$result = $conn->query("SELECT i.idIncidencia, i.data, i.prioritat, i.descripcio, d.nom AS departament, tp.nom AS tipus, t.nom AS tecnic    
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
<body class="min-vh-100 bg-light py-5">
<div class="container">
    <h2 class="mb-4">Estat de les incidències</h2>

    <form method="GET" class="d-flex gap-2 mb-4">
        <input type="number" name="id" class="form-control w-auto" placeholder="Cerca per ID" value="<?= $id ?>">
        <button type="submit" class="btn btn-info text-white">Cercar</button>
        <a href="estado_incidencia_profesor.php" class="btn btn-secondary">Veure totes</a>
    </form>

    <table class="table table-secondary">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Departament</th>
                <th>Tipus</th>
                <th>Tecnic</th>
                <th>Prioritat</th>
                <th>Descripció</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['idIncidencia'] ?></td>
                <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                <td><?= $row['departament'] ?></td>
                <td><?= $row['tipus'] ?></td>
                <td><?= $row['tecnic'] ?? 'Sense assignar' ?></td>
                <td><?= $row['prioritat'] ?: 'Sense assignar' ?></td>
                <td><?= $row['descripcio'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-secondary">INICI</a>
        <a href="interfaz_incidencias_profesor.php" class="btn btn-secondary">VOLVER</a>
    </div>
</div>
</body>
</html>