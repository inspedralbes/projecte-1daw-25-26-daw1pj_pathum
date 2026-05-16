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
    $accion = $_POST['accion']; 

   
    $conn->query("INSERT INTO ACTUACIO (descripcio, data, temps, incidencia, visible)
        VALUES ('$comentari', '$dataFi', $temps, $idIncidencia, $visible)");
    
    
    if ($accion === 'finalizar') {
        $conn->query("UPDATE INCIDENCIA SET dataFinalitzacio = '$dataFi' WHERE idIncidencia = $idIncidencia");
    }

    
    header("Location: incidencies_tecnico.php?id=$idTecnic");
    exit();
}
$incidencia = $conn->query("SELECT * FROM INCIDENCIA WHERE idIncidencia = $idIncidencia")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100"> 
<?php include 'header.php'; ?>

<main class="flex-grow-1 py-4">
    <div class="container" style="max-width: 600px;">
        <h2 class="fw-bold mb-4 h3 text-uppercase">Gestionar Incidència #<?= $idIncidencia ?></h2>

        <?php if ($incidencia): ?>
        <div class="bg-white p-4 rounded shadow-sm mb-4 border text-dark">
            <p><strong>Descripció:</strong><br><?= htmlspecialchars($incidencia['descripcio']) ?></p>
            <p class="mb-0 small text-muted">Data obertura: <?= date('d/m/Y', strtotime($incidencia['data'])) ?></p>
        </div>

        <div class="bg-white p-4 rounded shadow-sm border">
            <form method="POST" id="miFormulario">
                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Descripció de l'actuació:</label>
                    <textarea name="comentari_tecnic" id="textoSolucion" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Temps invertit:</label>
                    <div class="d-flex gap-2">
                        <div class="input-group">
                            <input type="number" name="hores" class="form-control" min="0" value="0">
                            <span class="input-group-text bg-secondary text-white border-secondary">h</span>
                        </div>
                        <div class="input-group">
                            <input type="number" name="minuts" class="form-control" min="0" max="59" value="0">
                            <span class="input-group-text bg-secondary text-white border-secondary">min</span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-uppercase">Data:</label>
                    <input type="date" name="data_fi" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" name="visible_usuari" class="form-check-input" id="visible" checked>
                    <label class="form-check-label small fw-bold" for="visible">VISIBLE PER L'USUARI</label>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" name="accion" value="añadir" class="btn btn-primary py-2 fw-bold shadow-sm">AFEGIR ACTUACIÓ</button>
                    <button type="submit" name="accion" value="finalizar" class="btn btn-danger py-2 fw-bold shadow-sm">FINALITZAR INCIDÈNCIA</button>
                </div>
            </form>
        </div>
        <?php else: ?>
            <div class="alert alert-warning shadow-sm">No s'ha trobat la incidència.</div>
        <?php endif; ?>

        <div class="mt-4 mb-5 text-center">
            <a href="incidencies_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary px-5 py-2 fw-bold shadow-sm">VOLVER</a>
        </div>
    </div>
</main>

<?php include 'footer.php'; ?>

<script src="js/Caracteres.js"></script>

</body>
</html>