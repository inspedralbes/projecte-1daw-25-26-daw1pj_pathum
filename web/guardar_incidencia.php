<?php
require_once 'connexio.php';

$descripcio  = $_POST['descripcio'];
$data        = $_POST['data'];
$departament = (int) $_POST['departament'];
$tecnic      = (int) $_POST['tecnic'];
$tipo        = (int) $_POST['tipo'];
$prioritat   = $_POST['prioritat'];

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
