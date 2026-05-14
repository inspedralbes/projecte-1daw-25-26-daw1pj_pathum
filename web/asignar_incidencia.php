<?php
require_once 'connexio.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$inc = $conn->query("SELECT * FROM INCIDENCIA WHERE idIncidencia = $id")->fetch_assoc();
$tecnics = $conn->query("SELECT * FROM TECNIC");
$tipus = $conn->query("SELECT * FROM TIPO");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignar Incidència - Institut Pedralbes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <?php include 'header.php'; ?>

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="container my-auto">
            <div class="row justify-content-center">
                
                <div class="col-11 col-md-8 col-lg-6 bg-white p-4 p-md-5 shadow-sm rounded border">

                    <h2 class="mb-2 fw-bold text-uppercase h3">Assignar Incidència #<?= $id ?></h2>
                    <p class="text-muted mb-4 small"><?= htmlspecialchars($inc['descripcio']) ?></p>

                    <form action="guardar_asignacion.php" method="POST">
                        <input type="hidden" name="id" value="<?= $id ?>">

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold small text-uppercase">Seleccionar Tècnic:</label>
                            <select name="tecnic" class="form-select">
                                <?php while ($row = $tecnics->fetch_assoc()): ?>
                                    <option value="<?= $row['idTecnic'] ?>" <?= ($inc['tecnic'] == $row['idTecnic']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['nom']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-3 text-start">
                            <label class="form-label fw-bold small text-uppercase">Tipus d'Incidència:</label>
                            <select name="tipo" class="form-select">
                                <?php while ($row = $tipus->fetch_assoc()): ?>
                                    <option value="<?= $row['idTipo'] ?>" <?= ($inc['tipo'] == $row['idTipo']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($row['nom']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <div class="mb-4 text-start"> <label class="form-label fw-bold small text-uppercase">Prioritat:</label>
                            <select name="prioritat" class="form-select">
                                <option value="Alta" <?= ($inc['prioritat'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
                                <option value="Mitja" <?= ($inc['prioritat'] == 'Mitja') ? 'selected' : '' ?>>Mitja</option>
                                <option value="Baixa" <?= ($inc['prioritat'] == 'Baixa') ? 'selected' : '' ?>>Baixa</option>
                            </select>
                        </div>

                        <div class="d-flex flex-column flex-sm-row justify-content-between gap-3 mt-4 mb-2">
                            <a href="listado_incidencias_admin.php" class="btn btn-secondary px-4 py-2 fw-bold text-uppercase">Volver</a>
                            <button type="submit" class="btn btn-info px-4 py-2 fw-bold text-uppercase text-dark shadow-sm">Guardar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>