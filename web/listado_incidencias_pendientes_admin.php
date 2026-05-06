<?php
require_once 'connexio.php';

$sql = "
    SELECT 
        i.idIncidencia,
        i.descripcio,
        i.data,
        i.prioritat,
        d.nom AS departament,
        t.nom AS tecnic,
        tp.nom AS tipus
    FROM INCIDENCIA i
    LEFT JOIN DEPARTMENT d  ON i.departament = d.idDepartment
    LEFT JOIN TECNIC t      ON i.tecnic = t.idTecnic
    LEFT JOIN TIPO tp       ON i.tipo = tp.idTipo
    WHERE i.dataFinalitzacio IS NULL
    ORDER BY i.data DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Incidències Pendents</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex flex-column align-items-center justify-content-center bg-light py-5">
  <div class="container">

    <h2 class="mb-4">Llistat de les Incidències pendents</h2>

    <table class="table table-secondary table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Descripció</th>
          <th>Departament</th>
          <th>Tipus</th>
          <th>Tècnic</th>
          <th>Prioritat</th>
          <th>Data</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result && $result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php
              $prioritatClass = match($row['prioritat']) {
                  'Alta'  => 'bg-danger',
                  'Mitja' => 'bg-warning text-dark',
                  'Baixa' => 'bg-info text-dark',
                  default => 'bg-secondary'
              };
            ?>
            <tr>
              <td><?= $row['idIncidencia'] ?></td>
              <td><?= htmlspecialchars($row['descripcio']) ?></td>
              <td><?= htmlspecialchars($row['departament']) ?></td>
              <td><?= htmlspecialchars($row['tipus']) ?></td>
              <td><?= htmlspecialchars($row['tecnic']) ?></td>
              <td><span class="badge <?= $prioritatClass ?>"><?= $row['prioritat'] ?></span></td>
              <td><?= date('d/m/Y H:i', strtotime($row['data'])) ?></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7" class="text-center text-muted">No hi ha incidències pendents.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="d-flex justify-content-between mt-4">
      <a href="index.php" class="btn btn-secondary shadow-sm">INICI</a>
      <a href="listado_incidencias_admin.php" class="btn btn-secondary shadow-sm">VOLVER</a>
    </div>

  </div>
</body>
</html>
