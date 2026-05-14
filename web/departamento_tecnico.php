<?php require_once 'logger.php'; ?>

<?php
require_once 'connexio.php';

$result = $conn->query("
    SELECT 
        d.nom AS departament,
        COUNT(i.idIncidencia) AS num_incidencies,
        (SELECT SUM(a.temps) FROM ACTUACIO a WHERE a.incidencia IN 
            (SELECT idIncidencia FROM INCIDENCIA WHERE departament = d.idDepartment)
        ) AS temps_total
    FROM DEPARTMENT d
    LEFT JOIN INCIDENCIA i ON i.departament = d.idDepartment
    GROUP BY d.idDepartment, d.nom
    ORDER BY num_incidencies DESC
");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Consum per Departaments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php include 'header.php'; ?>

<div class="container mt-4 mb-5 pb-5">

    <h2 class="mb-4">Consum per Departaments</h2>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-secondary table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr>
                    <th>Departament</th>
                    <th>Nombre d'incidències</th>
                    <th>Temps total dedicat</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['departament']) ?></td>
                        <td><?= $row['num_incidencies'] ?></td>
                        <td><?= $row['temps_total'] ?? 0 ?> min</td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="text-center py-4 text-muted">No hi ha dades.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        <a href="index.php" class="btn btn-secondary">INICI</a>
        <a href="listado_incidencias_admin.php" class="btn btn-secondary">TORNAR</a>
    </div>

</div>

<?php include 'footer.php'; ?>

</body>
</html>