<?php
require_once 'connexio.php';


$idIncidencia = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$idTecnic = isset($_GET['tecnic']) ? (int)$_GET['tecnic'] : 0;


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tancar'])) {
    $dataFi = $_POST['data_fi'];
    
    
    $sql_update = "UPDATE INCIDENCIA SET dataFinalitzacio = '$dataFi' WHERE idIncidencia = $idIncidencia";
    
    if ($conn->query($sql_update)) {
        header("Location: modificar_incidencia_tecnico.php?id=$idTecnic");
        exit();
    } else {
        echo "Error al tancar: " . $conn->error;
    }
}


$res_inc = $conn->query("SELECT idIncidencia, descripcio, data FROM INCIDENCIA WHERE idIncidencia = $idIncidencia");
$incidencia = $res_inc->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="py-5 bg-white text-center"> <?php include 'header.php'; ?>

    <div class="container" style="max-width: 600px;">
        <h1 class="fw-bold mb-5">Gestionar Incidència</h1>

        <?php if ($incidencia): ?>
            <div class="border p-4 rounded mb-4 bg-light text-start shadow-sm">
                <p><strong>ID:</strong> #<?= $incidencia['idIncidencia'] ?></p>
                <p><strong>Descripció:</strong> <?= $incidencia['descripcio'] ?></p>
                <p><strong>Data obertura:</strong> <?= date('d/m/Y', strtotime($incidencia['data'])) ?></p>
            </div>

            <div class="border p-4 rounded mb-4 bg-white text-start shadow-sm">
                <h5 class="fw-bold text-danger mb-3">TANCAR INCIDÈNCIA</h5>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Data de tancament:</label>
                        <input type="date" name="data_fi" class="form-control" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <button type="submit" name="tancar" class="btn btn-danger w-100 fw-bold">FINALITZAR</button>
                </form>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">No s'ha trobat la incidència. Revisa l'ID.</div>
        <?php endif; ?>

        <div class="mt-4">
            <a href="modificar_incidencia_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary px-4">VOLVER</a>
        </div>
    </div>

</body>
</html>