<?php
require_once 'connexio.php';

$sql = "
    SELECT 
        i.idIncidencia,
        i.descripcio,
        t.nom AS tecnic
    FROM INCIDENCIA i
    LEFT JOIN TECNIC t ON i.tecnic = t.idTecnic
    ORDER BY i.idIncidencia DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assignació d'Incidències</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex flex-column align-items-center justify-content-center bg-light py-5">
<div class="container">

  <h2 class="mb-4">Assignació d'Incidències</h2>

  <table class="table table-secondary table-hover">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Descripció</th>
        <th>Tècnic</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['idIncidencia'] ?></td>
            <td><?= htmlspecialchars($row['descripcio']) ?></td>
            <td><?= htmlspecialchars($row['tecnic']) ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="3" class="text-center text-muted">No hi ha incidències registrades.</td>
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
