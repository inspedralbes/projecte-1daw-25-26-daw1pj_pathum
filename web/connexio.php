<?php
$servername = "db";
$username = "usuari";
$password = "paraula_de_pas";
$dbname = "incidencies";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de connexió: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
