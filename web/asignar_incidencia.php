<?php
require_once 'connexio.php';

$id = $_GET['id'];

$inc = $conn->query("SELECT * FROM INCIDENCIA WHERE idIncidencia = $id")->fetch_assoc();
$tecnics = $conn->query("SELECT * FROM TECNIC");
$tipus = $conn->query("SELECT * FROM TIPO");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Assignar Incidència - Institut Pedralbes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-md-6 bg-white p-5 shadow-sm rounded border">

                <h2 class="mb-2 fw-bold">Assignar Incidència #<?= $id ?></h2>
                <p class="text-muted mb-4"><?= htmlspecialchars($inc['descripcio']) ?></p>

                <form action="guardar_asignacion.php" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Seleccionar Tècnic:</label>
                        <select name="tecnic" class="form-select">
                            <?php while ($row = $tecnics->fetch_assoc()): ?>
                                <option value="<?= $row['idTecnic'] ?>" <?= ($inc['tecnic'] == $row['idTecnic']) ? 'selected' : '' ?>>
                                    <?= $row['nom'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Tipus d'Incidència:</label>
                        <select name="tipo" class="form-select">
                            <?php while ($row = $tipus->fetch_assoc()): ?>
                                <option value="<?= $row['idTipo'] ?>" <?= ($inc['tipo'] == $row['idTipo']) ? 'selected' : '' ?>>
                                    <?= $row['nom'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Prioritat:</label>
                        <select name="prioritat" class="form-select">
                            <option value="Alta" <?= ($inc['prioritat'] == 'Alta') ? 'selected' : '' ?>>Alta</option>
                            <option value="Mitja" <?= ($inc['prioritat'] == 'Mitja') ? 'selected' : '' ?>>Mitja</option>
                            <option value="Baixa" <?= ($inc['prioritat'] == 'Baixa') ? 'selected' : '' ?>>Baixa</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-5">
                        <a href="listado_incidencias_admin.php" class="btn btn-secondary px-4 fw-bold">VOLVER</a>
                        <button type="submit" class="btn btn-info px-4 fw-bold">GUARDAR</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>