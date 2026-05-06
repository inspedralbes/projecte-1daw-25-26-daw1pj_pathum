<?php
require_once 'connexio.php';

$descripcio  = $_POST['descripcio'];
$data        = $_POST['data'];
$departament = (int) $_POST['departament'];

$resTecnic = $conn->query("SELECT idTecnic FROM TECNIC ORDER BY idTecnic LIMIT 1");
$rowTecnic = $resTecnic->fetch_assoc();
$tecnic = $rowTecnic['idTecnic'];

$resTipo = $conn->query("SELECT idTipo FROM TIPO ORDER BY idTipo LIMIT 1");
$rowTipo = $resTipo->fetch_assoc();
$tipo = $rowTipo['idTipo'];

$prioritat = 'Mitja';

$stmt = $conn->prepare(
    "INSERT INTO INCIDENCIA (descripcio, data, departament, tecnic, tipo, prioritat)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssiiss", $descripcio, $data, $departament, $tecnic, $tipo, $prioritat);

if ($stmt->execute()) {
    header("Location: listado_incidencias_admin.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}
?>
