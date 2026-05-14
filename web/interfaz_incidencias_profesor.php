<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfície d'Incidències - Institut Pedralbes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

    <?php include 'header.php'; ?>

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="container my-auto">
            <div class="row justify-content-center">
                
                <div class="col-10 col-md-6 col-lg-4 text-center">
                    
                    <h1 class="mb-5 fw-bold text-dark text-uppercase h2">Interfície d'incidències</h1>
                    
                    <div class="d-grid gap-3">
                        <a href="crear_incidencia.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase text-dark">Crear nova incidència</a>
                        <a href="estado_incidencia_profesor.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase text-dark">Estat d'una incidència</a>
                    </div>

                    <div class="mt-5 mb-3">
                        <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase shadow-sm">Volver</a>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>