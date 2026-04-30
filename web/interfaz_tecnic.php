<?php
require_once 'connexio.php';
$tecnics = $conn->query("SELECT idTecnic, nom FROM TECNIC ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Interfície Tècnic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="vh-100 d-flex align-items-center justify-content-center bg-light">
  <div class="container text-center">
    <div class="row justify-content-center">
      <div class="col-12 col-md-4">

        <h1 class="mb-5 fw-bold">Selecciona el Tècnic</h1>

        <div class="d-grid gap-3">
          <?php while ($row = $tecnics->fetch_assoc()): ?>
            <a href="incidencias_tecnic.php?id=<?= $row['idTecnic'] ?>" class="btn btn-info py-3 shadow-sm">
              <?= htmlspecialchars($row['nom']) ?>
            </a>
          <?php endwhile; ?>
        </div>

        <div class="d-flex justify-content-end mt-3">
          <a href="index.php" class="btn btn-secondary shadow-sm">Volver</a>
        </div>

      </div>
    </div>
  </div>
</body>
</html>
