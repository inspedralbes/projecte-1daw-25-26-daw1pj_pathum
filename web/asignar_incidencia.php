<?php require_once 'logger.php'; ?>

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
    <title>Assignar Incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="vh-100 d-flex align-items-center justify-content-center bg-light">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 bg-white p-5 shadow-sm rounded">

            <h2 class="mb-4">Assignar Incidència #<?= $id ?></h2>
            <p><?= $inc['descripcio'] ?></p>

            <form action="guardar_asignacion.php" method="POST">
                <input type="hidden" name="id" value="<?= $id ?>">

                <div class="mb-3">
                    <label class="form-label">Tècnic:</label>
                    <select name="tecnic" class="form-control">
                        <?php while ($row = $tecnics->fetch_assoc()): ?>
                            <option value="<?= $row['idTecnic'] ?>"><?= $row['nom'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tipus:</label>
                    <select name="tipo" class="form-control">
                        <?php while ($row = $tipus->fetch_assoc()): ?>
                            <option value="<?= $row['idTipo'] ?>"><?= $row['nom'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Prioritat:</label>
                    <select name="prioritat" class="form-control">
                        <option value="Alta">Alta</option>
                        <option value="Mitja">Mitja</option>
                        <option value="Baixa">Baixa</option>
                    </select>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="listado_incidencias_admin.php" class="btn btn-secondary">VOLVER</a>
                    <button type="submit" class="btn btn-primary">GUARDAR</button>
                </div>

            </form>
        </div>
    </div>
</div>
</body>
</html>