<?php
require_once 'connexio.php';
$departaments = $conn->query("SELECT * FROM DEPARTMENT ORDER BY nom");
$tipus = $conn->query("SELECT * FROM TIPO ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <?php include 'header.php'; ?>

    <div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
        <div class="row justify-content-center w-100">
            <div class="col-12 col-md-6 bg-white p-5 shadow-sm rounded text-center">
                <h2 class="mb-5">Crear nova Incidència</h2>
                
                <form id="formCrear" action="guardar_incidencia.php" method="POST">
                    <div class="mb-4 text-start">
                        <label class="form-label">Departament:</label>
                        <select name="departament" id="selDep" class="form-control bg-secondary-subtle border-0">
                            <option value="">Selecciona un departament</option>
                            <?php while ($row = $departaments->fetch_assoc()): ?>
                                <option value="<?= $row['idDepartment'] ?>"><?= $row['nom'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4 text-start">
                        <label class="form-label">Tipus d'incidència:</label>
                        <select name="tipo" id="selTipo" class="form-control bg-secondary-subtle border-0">
                            <option value="">Selecciona un tipus</option>
                            <?php while ($row = $tipus->fetch_assoc()): ?>
                                <option value="<?= $row['idTipo'] ?>"><?= $row['nom'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    
                    <div class="mb-4 text-start">
                        <label class="form-label">Descripció:</label>
                        <textarea name="descripcio" id="txtDesc" class="form-control bg-secondary-subtle border-0" rows="4"></textarea>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <a href="index.php" class="btn btn-secondary px-4">INICI</a>
                        <a href="interfaz_incidencias_profesor.php" class="btn btn-secondary px-4">VOLVER</a>
                        <button type="submit" class="btn btn-primary px-4">CREAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        document.getElementById('formCrear').onsubmit = function(event) {
            var dep = document.getElementById('selDep').value;
            var tipo = document.getElementById('selTipo').value;
            var desc = document.getElementById('txtDesc').value;

            
            if (dep === "" || tipo === "" || desc.trim() === "") {
                alert("Error: Tots els camps són obligatoris!");
                event.preventDefault(); 
            }
        };
    </script>

</body>
</html>