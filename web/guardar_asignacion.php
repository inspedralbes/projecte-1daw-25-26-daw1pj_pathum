<?php

require_once 'connexio.php';

$id = $_POST['id'];
$tecnic = $_POST['tecnic'];
$tipo = $_POST['tipo'];
$prioritat = $_POST['prioritat'];

$conn->query("UPDATE INCIDENCIA SET tecnic=$tecnic, tipo=$tipo, prioritat='$prioritat' WHERE idIncidencia=$id");

header("Location: listado_incidencias_admin.php");
?>