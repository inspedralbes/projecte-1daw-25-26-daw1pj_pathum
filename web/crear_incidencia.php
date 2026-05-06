<?php
require_once 'connexio.php';
$departaments = $conn->query("SELECT idDepartment, nom FROM DEPARTMENT ORDER BY nom");
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Crear incidència</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="vh-100 d-flex align-items-center justify-content-center bg-light">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6 bg-white p-5 shadow-sm rounded text-center">

            <h2 class="mb-5">Crear nova Incidència</h2>

            <form action="guardar_incidencia.php" method="POST">

                <div class="mb-4 text-start">
                    <label class="form-label">Nom Departament:</label>
                    <select name="departament" class="form-control bg-secondary-subtle border-0" required>
                        <option value="">-- Selecciona un departament --</option>
                        <?php while ($row = $departaments->fetch_assoc()): ?>
                            <option value="<?= $row['idDepartment'] ?>"><?= htmlspecialchars($row['nom']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4 text-start">
                    <label class="form-label">Data d'Incidència:</label>
                    <input type="date" name="data" class="form-control bg-secondary-subtle border-0" required>
                </div>

                <div class="mb-4 text-start">
                    <label class="form-label">Descripció:</label>
                    <textarea name="descripcio" class="form-control bg-secondary-subtle border-0" rows="4" required></textarea>
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

</body>
</html>
