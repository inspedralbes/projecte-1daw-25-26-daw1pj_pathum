<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Benvinguts - Institut Pedralbes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white d-flex flex-column min-vh-100">

    <?php include 'header.php'; ?>

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="container">
            <div class="row justify-content-center">
                
                <div class="col-10 col-md-6 col-lg-4 text-center">
                    
                    <h1 class="mb-5 fw-bold text-dark text-uppercase">Benvinguts</h1>
                    
                    <div class="d-grid gap-3">
                        <a href="interfaz_tecnic.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase text-dark">Tècnic</a>
                        <a href="listado_incidencias_admin.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase text-dark">Administrador</a>
                        <a href="interfaz_incidencias_profesor.php" class="btn btn-info py-3 shadow-sm fw-bold text-uppercase text-dark">Professor</a>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>