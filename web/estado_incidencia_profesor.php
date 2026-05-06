<?php
require_once 'connexio.php';

$result = $conn->query("SELECT i.idIncidencia, i.data, i.prioritat, d.nom AS departament, tp.nom AS tipus, t.nom AS tecnic    
    FROM INCIDENCIA i
    LEFT JOIN DEPARTMENT d ON i.departament = d.idDepartment
    LEFT JOIN TIPO tp ON i.tipo = tp.idTipo
    LEFT JOIN TECNIC t ON i.tecnic = t.idTecnic");    
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
    <table class="table table-secondary">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Departament</th>
                <th>Tipus</th>
                <th>Tecnic</th>
                <th>Prioritat</th>
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