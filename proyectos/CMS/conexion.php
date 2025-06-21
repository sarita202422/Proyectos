<?php
$servername = "teclab.uct.cl";
$username = "sarita_marinao";
$password = "sarita_marinao2025";
$database = "sarita_marinao_db2";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>

