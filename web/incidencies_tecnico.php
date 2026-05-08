<?php
require_once 'connexio.php';

$idTecnic = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$resultat = $conn->query("SELECT nom FROM TECNIC WHERE idTecnic = $idTecnic");
$row = $resultat->fetch_assoc();
$nomTecnic = $row ? $row['nom'] : "Tècnic";
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Opcions de <?= htmlspecialchars($nomTecnic) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-white d-flex flex-column min-vh-100"> 
    
    <?php include 'header.php'; ?>

    <main class="flex-grow-1 d-flex align-items-center justify-content-center py-5">
        <div class="container">
            
            <div class="row justify-content-center">
                <div class="col-10 col-md-6 col-lg-5 text-center">
                    
                    <h1 class="mb-5 fw-bold text-dark text-uppercase">
                        OPCIONS DE <?= htmlspecialchars($nomTecnic) ?>
                    </h1>
                    
                    <div class="d-grid gap-3">
                        
                        <a href="listado_incidencias_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-info py-4 shadow-sm fw-bold text-dark">
                            LLISTAT D'INCIDÈNCIES<br>PENDENTS
                        </a>
                        
                        <a href="modificar_incidencia_tecnico.php?id=<?= $idTecnic ?>" class="btn btn-info py-4 shadow-sm fw-bold text-dark">
                            MODIFICAR INCIDÈNCIES
                        </a>

                        <div class="row g-2 mt-4"> 
                            <div class="col-6">
                                <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold shadow-sm">INICI</a>
                            </div>
                            <div class="col-6">
                                <a href="interfaz_tecnic.php" class="btn btn-secondary w-100 py-2 fw-bold shadow-sm">VOLVER</a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>