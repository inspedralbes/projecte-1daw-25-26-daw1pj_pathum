<?php
require_once 'connexio.php';

$descripcio  = $_POST['descripcio'];
$departament = (int) $_POST['departament'];
$tipo        = (int) $_POST['tipo'];

$conn->query("INSERT INTO INCIDENCIA (descripcio, data, departament, tipo) 
VALUES ('$descripcio', NOW(), $departament, $tipo)");

$id = $conn->insert_id;
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Incidència creada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="vh-100 d-flex align-items-center justify-content-center bg-light">
<div class="container text-center">
    <div class="col-12 col-md-4 mx-auto bg-white p-5 shadow-sm rounded">
        <h2 class="mb-4">Incidència creada!</h2>
        <p class="fs-5">El teu número d'incidència és:</p>
        <h1 class="fw-bold text-info">#<?= $id ?></h1>
        <div class="d-grid gap-3 mt-4">
            <a href="interfaz_incidencias_profesor.php" class="btn btn-secondary">VOLVER</a>
            <a href="index.php" class="btn btn-secondary">INICI</a>
        </div>
    </div>
</div>
</body>
</html>