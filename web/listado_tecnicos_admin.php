<?php
require_once 'connexio.php';

$sql = "
    SELECT 
        t.idTecnic,
        t.nom,
        COUNT(CASE WHEN i.dataFinalitzacio IS NULL THEN 1 END) AS pendents,
        COUNT(CASE WHEN i.dataFinalitzacio IS NOT NULL THEN 1 END) AS finalitzades
    FROM TECNIC t
    LEFT JOIN INCIDENCIA i ON i.tecnic = t.idTecnic
    GROUP BY t.idTecnic, t.nom
    ORDER BY t.nom
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Llistat de Tècnics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex flex-column align-items-center justify-content-center bg-light py-5">
<div class="container">

  <h2 class="mb-4">Llistat de Tècnics</h2>

  <table class="table table-secondary table-hover">
    <thead class="table-dark">
      <tr>
        <th>Nom</th>
        <th>Disponibilitat</th>
        <th>Incidències Pendents</th>
        <th>Incidències Finalitzades</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php $disponible = $row['pendents'] == 0 ? true : false; ?>
          <tr>
            <td><?= htmlspecialchars($row['nom']) ?></td>
            <td>
              <?php if ($disponible): ?>
                <span class="badge bg-success">Disponible</span>
              <?php else: ?>
                <span class="badge bg-danger">Ocupat</span>
              <?php endif; ?>
            </td>
            <td><?= $row['pendents'] ?></td>
            <td><?= $row['finalitzades'] ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" class="text-center text-muted">No hi ha tècnics registrats.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>

  <div class="d-flex justify-content-between mt-4">
    <a href="index.php" class="btn btn-secondary shadow-sm">INICI</a>
    <a href="interfaz_admin.php" class="btn btn-secondary shadow-sm">VOLVER</a>
  </div>

</div>
</body>
</html>
