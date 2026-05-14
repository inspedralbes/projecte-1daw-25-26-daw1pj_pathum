<?php require_once 'logger.php'; ?>

<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Interfície d'Incidències - Institut Pedralbes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        
        <div class="text-center" style="max-width: 400px; width: 100%;">
            
            <h1 class="mb-5 fw-bold text-dark text-uppercase">Interfície d'incidències</h1>
            
            <div class="d-grid gap-3">
                <a href="crear_incidencia.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase">Crear nova incidència</a>
                <a href="estado_incidencia_profesor.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase">Estat d'una incidència</a>
            </div>

            <div class="mt-4">
                <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase shadow-sm">Volver</a>
            </div>

        </div>

    </div>

    <?php include 'footer.php'; ?>

</body>
</html>