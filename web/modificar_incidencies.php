<?php
require_once 'connexio.php';

$idTecnic = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$res_tec = $conn->query("SELECT nom FROM TECNIC WHERE idTecnic = $idTecnic");
$row_tec = $res_tec->fetch_assoc();
$nomTecnic = $row_tec ? $row_tec['nom'] : "Tècnic";


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear_incidencia'])) {
    $descripcio = $_POST['descripcio'];
    $dataInici = $_POST['data_inici'];
    
    $sql_insert = "INSERT INTO INCIDENCIA (descripcio, data, tecnic) 
                    VALUES ('$descripcio', '$dataInici', $idTecnic)";
    
    if ($conn->query($sql_insert)) {
        header("Location: modificar_incidencies.php?id=$idTecnic");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$resultat = $conn->query("SELECT idIncidencia, descripcio, data FROM INCIDENCIA WHERE tecnic = $idTecnic AND dataFinalitzacio IS NULL ORDER BY idIncidencia DESC");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Modificar Incidències</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="py-5 bg-white"> <?php include 'header.php'; ?>
    <div class="container text-center" style="max-width: 800px;">
        <h1 class="fw-bold mb-1">Modificar Incidències</h1>
        <h5 class="text-muted mb-5">Tècnic: <?= $nomTecnic ?></h5>

        <div class="border p-4 rounded mb-5 bg-light text-start shadow-sm">
            <h5 class="fw-bold mb-3"> CREAR NOVA INCIDÈNCIA</h5>
            <form action="" method="POST" class="row g-3">
                <input type="hidden" name="crear_incidencia" value="1">
                <div class="col-md-7">
                    <label class="form-label fw-bold">Descripció:</label>
                    <input type="text" name="descripcio" class="form-control" required>
                </div>
                <div class="col-md-5">
                    <label class="form-label fw-bold">Data d'Inici:</label>
                    <input type="date" name="data_inici" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-info w-100 fw-bold">CREAR I GUARDAR</button>
                </div>
            </form>
        </div>

        <h5 class="text-start fw-bold mb-3"> INCIDÈNCIES EN CURS:</h5>
        <?php if ($resultat && $resultat->num_rows > 0): ?>
            <table class="table border">
                <thead class="table-secondary">
                    <tr>
                        <th>ID</th>
                        <th>Descripció</th>
                        <th>Acció</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($inc = $resultat->fetch_assoc()): ?>
                        <tr>
                            <td>#<?= $inc['idIncidencia'] ?></td>
                            <td><?= $inc['descripcio'] ?></td>
                            <td><a href="gestionar_incidencia.php?id=<?= $inc['idIncidencia'] ?>&tecnic=<?= $idTecnic ?>" class="btn btn-sm btn-info">Gestionar</a></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-success">No tens incidències pendents.</div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="incidencias_tecnic.php?id=<?= $idTecnic ?>" class="btn btn-secondary">VOLVER</a>
        </div>
    </div>
</body>
</html>