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
    <title>Incidències Pendents - <?= $nomTecnic ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white"> 
    
    <?php include 'header.php'; ?>

    <div class="container text-center mt-5" style="max-width: 800px;">
        
        <h1 class="mb-2 fw-bold text-dark">Llistat d'Incidències Pendents</h1>
        <h5 class="text-muted mb-5">Tècnic: <?= $nomTecnic ?></h5>
        
        <?php if ($resultat && $resultat->num_rows > 0): ?>
            <div class="table-responsive shadow-sm rounded border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th class="py-3" style="width: 15%;">ID</th>
                            <th class="py-3" style="width: 25%;">Data d'Inici</th>
                            <th class="py-3 text-start">Descripció de la Incidència</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($inc = $resultat->fetch_assoc()): ?>
                            <tr>
                                <td class="fw-bold py-3">#<?= $inc['idIncidencia'] ?></td>
                                <td class="py-3"><?= date('d/m/Y', strtotime($inc['data'])) ?></td>
                                <td class="text-start py-3"><?= $inc['descripcio'] ?></td>
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

        <div class="row g-2 mt-5 mb-5 pb-5 justify-content-center">
            <div class="col-6 col-md-4">
                <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold">INICI</a>
            </div>
            <div class="col-6 col-md-4">
                <a href="incidencias_tecnic.php?id=<?= $idTecnic ?>" class="btn btn-secondary w-100 py-2 fw-bold">VOLVER</a>
            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>

</body> 
</html>