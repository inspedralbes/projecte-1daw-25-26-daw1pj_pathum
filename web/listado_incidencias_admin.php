<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Llistat Incidències</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="min-vh-100 d-flex flex-column align-items-center justify-content-center bg-light py-5">
  <div class="container">

    <div class="d-flex gap-3 mb-4">
      <a href="#" class="btn btn-info text-white px-4 py-2 shadow-sm">FINALITZADES</a>
      <a href="#" class="btn btn-info text-white px-4 py-2 shadow-sm">PENDENTS</a>
    </div>

    <h2 class="mb-4">Llistat de totes les Incidències</h2>

    <table class="table table-secondary">
      <thead>
        <tr>
          <th>ID</th>
          <th>Descripció</th>
          <th>Estat</th>
          <th>Tècnics</th>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>

    <div class="d-flex justify-content-between mt-4">
      <a href="index.php" class="btn btn-secondary shadow-sm">INICI</a>
      <a href="interfaz_admin.php" class="btn btn-secondary shadow-sm">VOLVER</a>
    </div>

  </div>
</body>
</html>