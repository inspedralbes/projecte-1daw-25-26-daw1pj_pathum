<?php require_once 'logger.php'; ?>

<?php
require_once 'connexio.php';
$idIncidencia = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$idTecnic = isset($_GET['tecnic']) ? (int)$_GET['tecnic'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dataFi = $_POST['data_fi'];
    $comentari = $conn->real_escape_string($_POST['comentari_tecnic']);
    $hores = (int)$_POST['hores'];
    $minuts = (int)$_POST['minuts'];
    $temps = $hores * 60 + $minuts;
    $visible = isset($_POST['visible_usuari']) ? 1 : 0;
    $accion = $_POST['accion']; // Detectar qué botón se pulsó

    // 1. Insertar siempre la actuación en la tabla ACTUACIO
    $conn->query("INSERT INTO ACTUACIO (descripcio, data, temps, incidencia, visible)
        VALUES ('$comentari', '$dataFi', $temps, $idIncidencia, $visible)");
    
    // 2. Si el botón pulsado es "finalizar", actualizamos la incidencia
    if ($accion === 'finalizar') {
        $conn->query("UPDATE INCIDENCIA SET dataFinalitzacio = '$dataFi' WHERE idIncidencia = $idIncidencia");
    }

    // 3. Redirigir siempre de vuelta al listado
    header("Location: incidencies_tecnico.php?id=$idTecnic");
    exit();
}
$incidencia = $conn->query("SELECT * FROM INCIDENCIA WHERE idIncidencia = $idIncidencia")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light" style="padding-bottom: 80px;"> 
<?php include 'header.php'; ?>

<div class="container" style="max-width: 600px; margin-top: 20px !important;">
    <h2 class="fw-bold mb-4">Gestionar Incidència #<?= $idIncidencia ?></h2>

    <?php if ($incidencia): ?>
    <div class="bg-white p-4 rounded shadow-sm mb-4">
        <p><strong>Descripció:</strong> <?= htmlspecialchars($incidencia['descripcio']) ?></p>
        <p class="mb-0"><strong>Data obertura:</strong> <?= date('d/m/Y', strtotime($incidencia['data'])) ?></p>
    </div>

    <div class="bg-white p-4 rounded shadow-sm">
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Descripció de l'actuació:</label>
                <textarea name="comentari_tecnic" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Temps invertit:</label>
                <div class="d-flex gap-2">
                    <div class="input-group">
                        <input type="number" name="hores" class="form-control" min="0" value="0">
                        <span class="input-group-text">h</span>
                    </div>
                    <div class="input-group">
                        <input type="number" name="minuts" class="form-control" min="0" max="59" value="0">
                        <span class="input-group-text">min</span>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Data:</label>
                <input type="date" name="data_fi" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>

            <div class="mb-4 form-check">
                <input type="checkbox" name="visible_usuari" class="form-check-input" id="visible" checked>
                <label class="form-check-label" for="visible">Visible per l'usuari</label>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" name="accion" value="añadir" class="btn btn-primary">AFEGIR ACTUACIÓ</button>
                <button type="submit" name="accion" value="finalizar" class="btn btn-danger">FINALITZAR INCIDÈNCIA</button>
            </div>
        </form>
    </div>
    <?php else: ?>
        <div class="alert alert-warning">No s'ha trobat la incidència.</div>
    <?php endif; ?>

    <div class="mt-3">
        <a href="incidencies_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary">VOLVER</a>
    </div>
</div>
<?php include 'footer.php'; ?>
</body>
</html>