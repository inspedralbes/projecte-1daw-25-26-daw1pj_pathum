<?php
require_once 'connexio.php';

$sql = "
    SELECT 
        i.idIncidencia,
        i.descripcio,
        i.data,
        i.dataFinalitzacio,
        i.prioritat,
        d.nom AS departament,
        t.nom AS tecnic,
        tp.nom AS tipus
    FROM INCIDENCIA i
    LEFT JOIN DEPARTMENT d  ON i.departament = d.idDepartment
    LEFT JOIN TECNIC t      ON i.tecnic = t.idTecnic
    LEFT JOIN TIPO tp       ON i.tipo = tp.idTipo
    WHERE i.dataFinalitzacio IS NOT NULL
    ORDER BY i.dataFinalitzacio DESC
";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Incidències Finalitzades - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

  <?php include 'header.php'; ?>

  <div class="container mt-5 mb-5 pb-5">

    <h2 class="mb-4 fw-bold">Llistat de les Incidències finalitzades</h2>

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
              <th>Data inici</th>
              <th>Data fi</th>
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
                  <td class="fw-bold">#<?= $row['idIncidencia'] ?></td>
                  <td><?= htmlspecialchars($row['descripcio'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['departament'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['tipus'] ?? '') ?></td>
                  <td><?= htmlspecialchars($row['tecnic'] ?? '') ?></td>
                  <td><span class="badge <?= $prioritatClass ?>"><?= $row['prioritat'] ?></span></td>
                  <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
                  <td><?= date('d/m/Y', strtotime($row['dataFinalitzacio'])) ?></td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="8" class="text-center text-muted py-4">No hi ha incidències finalitzades.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
      <a href="index.php" class="btn btn-secondary shadow-sm fw-bold">INICI</a>
      <a href="listado_incidencias_admin.php" class="btn btn-secondary shadow-sm fw-bold">VOLVER</a>
    </div>

  </div>

  <?php include 'footer.php'; ?>

</body>
</html>