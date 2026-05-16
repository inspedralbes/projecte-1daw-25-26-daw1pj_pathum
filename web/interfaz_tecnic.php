<?php
require_once 'connexio.php';

$tecnics = $conn->query("SELECT idTecnic, nom FROM TECNIC ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Interfície Tècnic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white"> 
  
  <?php include 'header.php'; ?>

  <div class="container text-center mt-5 py-5">
    
    <div class="row justify-content-center">
      <div class="col-10 col-sm-8 col-md-4">

        <h1 class="mb-5 fw-bold text-dark text-uppercase h2">Selecciona el Tècnic</h1>

        <div class="d-grid gap-3">
          <?php while ($row = $tecnics->fetch_assoc()): ?>
            <a href="incidencies_tecnico.php?id=<?= $row['idTecnic'] ?>" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase">
              <?= htmlspecialchars($row['nom']) ?>
            </a>
          <?php endwhile; ?>
        </div>

        <div class="mt-5 mb-5">
          <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase">VOLVER</a>
        </div>

      </div>
    </div>

  </div>

  <?php include 'footer.php'; ?>

</body>
</html>