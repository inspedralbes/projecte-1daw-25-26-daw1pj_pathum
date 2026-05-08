<?php
require_once 'connexio.php';

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
    $sql .= " WHERE i.idIncidencia = '$idBusqueda'";
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
</head>
<body class="bg-light py-5">
  <div class="container shadow-sm p-4 bg-white rounded">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Llistat d'Incidències</h2>
        
        <form action="" method="GET" class="d-flex gap-2">
            <input type="number" name="id_busqueda" class="form-control" placeholder="Cerca per ID..." value="<?= htmlspecialchars($idBusqueda) ?>">
            <button type="submit" class="btn btn-primary">Cercar</button>
            <?php if(!empty($idBusqueda)): ?>
                <a href="?" class="btn btn-outline-secondary">Veure totes</a>
            <?php endif; ?>
        </form>
    </div>

    <table class="table table-hover">
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
              <td><strong>#<?= $row['idIncidencia'] ?></strong></td>
              <td><?= htmlspecialchars($row['descripcio'] ?? '') ?></td>
              <td><?= htmlspecialchars($row['departament'] ?? '') ?></td>
              <td><?= htmlspecialchars($row['tipus'] ?? '') ?></td>
              <td><?= htmlspecialchars($row['tecnic'] ?? 'Sense assignar') ?></td>
              <td><span class="badge <?= $prioritatClass ?>"><?= $row['prioritat'] ?></span></td>
              <td><?= date('d/m/Y', strtotime($row['data'])) ?></td>
              <td><span class="badge <?= $badgeClass ?>"><?= $estat ?></span></td>
              <td>
                <a href="asignar_incidencia.php?id=<?= $row['idIncidencia'] ?>" class="btn btn-sm btn-outline-primary">Gestionar</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="9" class="text-center py-4 text-muted">No s'ha trobat cap incidència amb aquests criteris.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>

    <div class="mt-4">
      <a href="index.php" class="btn btn-secondary">Inici</a>
    </div>

  </div>
</body>
</html>