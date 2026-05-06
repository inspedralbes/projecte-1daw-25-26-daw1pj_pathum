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
    <title>Opcions de <?= $nomTecnic ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="vh-100 d-flex align-items-center justify-content-center bg-white">

    <div class="container text-center">
        
        <h1 class="mb-5 fw-bold text-dark text-uppercase">
            OPCIONS DE <?= $nomTecnic ?>
        </h1>
        
        <div class="row justify-content-center">
            <div class="col-12 col-md-4">
                
                <div class="d-grid gap-3">
                    
                    <a href="llistat_incidencies.php?id=<?= $idTecnic ?>" class="btn btn-info py-4 shadow-sm fw-bold">
                        LLISTAT D'INCIDÈNCIES<br>PENDENTS
                    </a>
                    
                    <a href="modificar_incidencies.php?id=<?= $idTecnic ?>" class="btn btn-info py-4 shadow-sm fw-bold">
                        MODIFICAR INCIDÈNCIES
                    </a>

                    <div class="row g-2 mt-4">
                        <div class="col-6">
                            <a href="index.php" class="btn btn-secondary w-100 py-2 fw-bold">INICI</a>
                        </div>
                        <div class="col-6">
                            <a href="interfaz_tecnic.php" class="btn btn-secondary w-100 py-2 fw-bold">VOLVER</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

</body>
</html>