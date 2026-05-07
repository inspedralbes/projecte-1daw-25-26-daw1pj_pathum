<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interfície d'Administrador - Institut Pedralbes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white">

    <?php include 'header.php'; ?>

    <div class="container text-center" style="min-height: 75vh; display: flex; flex-direction: column; justify-content: center;">
        
        <div class="row justify-content-center">
            <div class="col-12 col-md-5">
                
                <h1 class="mb-5 fw-bold text-dark text-uppercase">Interfície d'Administrador</h1>
                
                <div class="d-grid gap-3">
                    <a href="listado_tecnicos_admin.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase">Buscar Tècnics</a>
                    <a href="listado_incidencias_admin.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase">Llistar totes les Incidències</a>
                </div>

                <div class="mt-4">
                    <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold text-uppercase shadow-sm">Volver</a>
                </div>

            </div>
        </div>

    </div>

    <?php include 'footer.php'; ?>

</body>
</html>