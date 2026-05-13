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

    $conn->query("INSERT INTO ACTUACIO (descripcio, data, temps, incidencia, visible)
        VALUES ('$comentari', '$dataFi', $temps, $idIncidencia, $visible)");
    $conn->query("UPDATE INCIDENCIA SET dataFinalitzacio = '$dataFi' WHERE idIncidencia = $idIncidencia");

    header("Location: modificar_incidencia_tecnico.php?id=$idTecnic");
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

        <h2 class="fw-bold mb-4 text-dark text-uppercase text-center">Gestionar Incidència #<?= $idIncidencia ?></h2>

        <?php if ($incidencia): ?>

        <div class="bg-white p-4 rounded shadow-sm mb-4 border">
            <p class="text-dark"><strong>Descripció:</strong> <?= htmlspecialchars($incidencia['descripcio']) ?></p>
            <p class="mb-0 text-dark"><strong>Data obertura:</strong> <?= date('d/m/Y', strtotime($incidencia['data'])) ?></p>
        </div>

        <div class="bg-white p-4 rounded shadow-sm border">
            <form method="POST" id="miFormulario">

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark text-uppercase small">Descripció de la solució:</label>
                    <textarea name="comentari_tecnic" id="textoSolucion" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark text-uppercase small">Temps invertit:</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="input-group">
                                <input type="number" name="hores" class="form-control" min="0" value="0">
                                <span class="input-group-text bg-secondary text-white">h</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="input-group">
                                <input type="number" name="minuts" class="form-control" min="0" max="59" value="0">
                                <span class="input-group-text bg-secondary text-white">min</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold text-dark text-uppercase small">Data de tancament:</label>
                    <input type="date" name="data_fi" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>

                <div class="mb-4 form-check">
                    <input type="checkbox" name="visible_usuari" class="form-check-input" id="visible" checked>
                    <label class="form-check-label fw-bold text-dark small" for="visible">VISIBLE PER L'USUARI</label>
                </div>

                <button type="submit" class="btn btn-danger w-100 py-2 fw-bold shadow-sm">FINALITZAR</button>
            </form>
        </div>

        <?php else: ?>
            <div class="alert alert-warning shadow-sm">No s'ha trobat la incidència.</div>
        <?php endif; ?>

        <div class="mt-4 mb-5 text-center">
            <a href="modificar_incidencia_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-secondary px-5 py-2 fw-bold shadow-sm">VOLVER</a>
        </div>

    </div>
</main>

<?php include 'footer.php'; ?>

<script>

    document.getElementById('miFormulario').onsubmit = function(event) {
        var comentario = document.getElementById('textoSolucion').value;

        if (comentario.length < 20) {
            alert("La descripció ha de tenir almenys 20 caràcters!");
            event.preventDefault();
        }
    };
</script>

</body>
</html>