<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Benvinguts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white"> 
    <?php include 'header.php'; ?>

    <div class="container text-center mt-5">
        
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                
                <h1 class="mb-5 fw-bold text-dark">BENVINGUTS</h1>
                
                <div class="d-grid gap-3">
                    <a href="interfaz_tecnic.php" class="btn btn-info py-3 shadow-sm fw-bold">TÈCNIC</a>
                    <a href="interfaz_admin.php" class="btn btn-info py-3 shadow-sm fw-bold">ADMINISTRADOR</a>
                    <a href="interfaz_incidencias_profesor.php" class="btn btn-info py-3 shadow-sm fw-bold">PROFESSOR</a>
                </div>

            </div>
        </div>

    </div>
    <?php include 'footer.php'; ?>
</body>
</html>