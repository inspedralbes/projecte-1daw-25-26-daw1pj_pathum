<?php
require_once 'connexio.php';

$idTecnic = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$res_tec = $conn->query("SELECT nom FROM TECNIC WHERE idTecnic = $idTecnic");
$row_tec = $res_tec->fetch_assoc();
$nomTecnic = $row_tec ? $row_tec['nom'] : "Tècnic";

$resultat = $conn->query("SELECT idIncidencia, descripcio, data FROM INCIDENCIA WHERE tecnic = $idTecnic AND dataFinalitzacio IS NULL ORDER BY data DESC");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidències Pendents - <?= htmlspecialchars($nomTecnic) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white d-flex flex-column min-vh-100"> 
    
    <?php include 'header.php'; ?>

    <main class="flex-grow-1 py-5">
        <div class="container text-center" style="max-width: 900px;">
            
            <h1 class="mb-2 fw-bold text-dark text-uppercase">Llistat d'Incidències Pendents</h1>
            <h5 class="text-muted mb-5">Tècnic: <?= htmlspecialchars($nomTecnic) ?></h5>
            
            <?php if ($resultat && $resultat->num_rows > 0): ?>
                <div class="table-responsive shadow-sm rounded border">
                    <table class="table table-hover align-middle mb-0 bg-white">
                        <thead class="table-secondary text-dark">
                            <tr>
                                <th class="py-3">ID</th>
                                <th class="py-3">Data d'Inici</th>
                                <th class="py-3 text-start">Descripció</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <?php while ($inc = $resultat->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold py-3">#<?= $inc['idIncidencia'] ?></td>
                                    <td class="py-3" style="white-space: nowrap;"><?= date('d/m/Y', strtotime($inc['data'])) ?></td>
                                    <td class="text-start py-3 small"><?= htmlspecialchars($inc['descripcio']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-success py-4 shadow-sm fw-bold">
                     No hi ha incidències pendents en aquest moment.
                </div>
            <?php endif; ?>

            <div class="row g-2 mt-5 mb-5 justify-content-center">
                <div class="col-5 col-md-3">
                    <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold shadow-sm">INICI</a>
                </div>
                <div class="col-5 col-md-3">
                    <a href="incidencies_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary w-100 py-2 fw-bold shadow-sm">VOLVER</a>
                </div>
            </div>

        </div>
    </main>

    <?php include 'footer.php'; ?>

</body> 
</html>