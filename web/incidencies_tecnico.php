<?php
require_once 'connexio.php';

$idTecnic = isset($_GET['id']) ? (int)$_GET['id'] : 0;


$res = $conn->query("SELECT nom FROM TECNIC WHERE idTecnic = $idTecnic");
$row = $res->fetch_assoc();
$nomTecnic = $row['nom'] ?? "Tècnic";


$sql = "SELECT idIncidencia, descripcio, data, dataFinalitzacio 
        FROM INCIDENCIA 
        WHERE tecnic = $idTecnic 
        ORDER BY dataFinalitzacio ASC, data DESC";
$resultat = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidències - <?= $nomTecnic ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-white d-flex flex-column min-vh-100"> 
    
    <?php include 'header.php'; ?>

    <main class="flex-grow-1 py-4">
        <div class="container" style="max-width: 900px;">
            
            <h1 class="mb-2 fw-bold text-dark h2 text-uppercase">Gestió d'Incidències</h1>
            <h5 class="text-muted mb-4">Tècnic: <?= htmlspecialchars($nomTecnic) ?></h5>
            
            <?php if ($resultat && $resultat->num_rows > 0): ?>
                <div class="table-responsive shadow-sm rounded border">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-secondary">
                            <tr>
                                <th class="py-3">ID</th>
                                <th class="py-3">Data</th>
                                <th class="py-3">Descripció</th>
                                <th class="py-3">Estat</th>
                                <th class="py-3 text-center">Acció</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($inc = $resultat->fetch_assoc()): 
                                $esPendent = is_null($inc['dataFinalitzacio']);
                            ?>
                                <tr>
                                    <td class="fw-bold">#<?= $inc['idIncidencia'] ?></td>
                                    <td style="white-space: nowrap;"><?= date('d/m/Y', strtotime($inc['data'])) ?></td>
                                    <td class="text-start"><?= htmlspecialchars($inc['descripcio']) ?></td>
                                    <td>
                                        <?php if($esPendent): ?>
                                            <span class="badge bg-warning text-dark">Pendent</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Finalitzada</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($esPendent): ?>
                                            <a href="gestionar_incidencia_tecnico.php?id=<?= $inc['idIncidencia'] ?>&tecnic=<?= $idTecnic ?>" 
                                               class="btn btn-info btn-sm text-white fw-bold shadow-sm">Gestionar</a>
                                        <?php else: ?>
                                            <small class="text-muted">---</small>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-light border py-4 text-center shadow-sm">
                     No tens incidències assignades.
                </div>
            <?php endif; ?>

            <div class="row g-3 mt-4 mb-5 justify-content-center">
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase">Inici</a>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <a href="interfaz_tecnic.php" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase">Volver</a>
                </div>
                <div class="col-12 col-sm-12 col-md-4">
                    <a href="tabla_actuacio_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase">Taula d'Actuacions</a>
                </div>
            </div>

        </div>
    </main>

    <?php include 'footer.php'; ?>

</body> 
</html>