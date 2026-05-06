<?php
require_once 'connexio.php';

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
    LEFT JOIN TIPO tp       ON i.tipo = tp.idTipo
    ORDER BY i.data DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Llistat Incidències</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="min-vh-100 d-flex flex-column align-items-center justify-content-center bg-light py-5">
  <div class="container">

    <div class="d-flex gap-3 mb-4">
      <a href="listado_incidencias_finalizadas_admin.php" class="btn btn-info text-white px-4 py-2 shadow-sm">FINALITZADES</a>
      <a href="listado_incidencias_pendientes_admin.php" class="btn btn-info text-white px-4 py-2 shadow-sm">PENDENTS</a>
    </div>

    <h2 class="mb-4">Llistat de totes les Incidències</h2>

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
          <th>Estat</th>
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
            ?>
            <tr>
              <td><?= $row['idIncidencia'] ?></td>
              <td><?= htmlspecialchars($row['descripcio']) ?></td>
              <td><?= htmlspecialchars($row['departament']) ?></td>
              <td><?= htmlspecialchars($row['tipus']) ?></td>
              <td><?= htmlspecialchars($row['tecnic']) ?></td>
              <td><span class="badge <?= $prioritatClass ?>"><?= $row['prioritat'] ?></span></td>
              <td><?= date('d/m/Y H:i', strtotime($row['data'])) ?></td>
              <td><span class="badge <?= $badgeClass ?>"><?= $estat ?></span></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="8" class="text-center text-muted">No hi ha incidències registrades.</td>
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
