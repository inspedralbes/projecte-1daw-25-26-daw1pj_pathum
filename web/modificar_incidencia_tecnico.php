<?php
require_once 'connexio.php';

$idTecnic = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$res_tec = $conn->query("SELECT nom FROM TECNIC WHERE idTecnic = $idTecnic");
$row_tec = $res_tec->fetch_assoc();
$nomTecnic = $row_tec ? $row_tec['nom'] : "Tècnic";

$resultat = $conn->query("SELECT idIncidencia, descripcio, data FROM INCIDENCIA WHERE tecnic = $idTecnic AND dataFinalitzacio IS NULL ORDER BY idIncidencia DESC");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidències Assignades - <?= htmlspecialchars($nomTecnic) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white d-flex flex-column min-vh-100"> 
    
    <?php include 'header.php'; ?>

    <main class="flex-grow-1 py-5">
        <div class="container text-center" style="max-width: 900px;">
            <h1 class="fw-bold mb-1 text-dark text-uppercase">Incidències Assignades</h1>
            <h5 class="text-muted mb-5">Tècnic: <?= htmlspecialchars($nomTecnic) ?></h5>

            <h5 class="text-start fw-bold mb-3 text-uppercase text-dark">Llistat de feina pendent:</h5>
            
            <?php if ($resultat && $resultat->num_rows > 0): ?>
                <div class="table-responsive shadow-sm rounded border mb-4">
                    <table class="table table-hover align-middle mb-0 bg-white">
                        <thead class="table-secondary text-dark">
                            <tr>
                                <th class="py-3">ID</th>
                                <th class="py-3 text-start">Descripció</th>
                                <th class="py-3">Acció</th>
                            </tr>
                        </thead>
                        <tbody class="text-dark">
                            <?php while ($inc = $resultat->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold py-3">#<?= $inc['idIncidencia'] ?></td>
                                    <td class="text-start py-3 small"><?= htmlspecialchars($inc['descripcio']) ?></td>
                                    <td class="py-3">
                                        <a href="gestionar_incidencia_tecnico.php?id=<?= $inc['idIncidencia'] ?>&tecnic=<?= $idTecnic ?>" class="btn btn-sm btn-info fw-bold shadow-sm text-dark text-uppercase" style="white-space: nowrap;">
                                            Gestionar/Tancar
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-success shadow-sm fw-bold py-4">
                    Molt bona feina! No tens incidències pendents de reparar.
                </div>
            <?php endif; ?>

            <div class="mt-5 mb-5">
                <a href="incidencies_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary px-5 py-2 fw-bold shadow-sm">VOLVER</a>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>