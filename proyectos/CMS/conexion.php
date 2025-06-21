<?php
$host = "teclab.uct.cl";
$user= "sarita_marinao";
$pass = "sarita_marinao2025";
$db = "sarita_marinao_db2";

// Crear conexión
$conn = mysqli_connect($host, $user, $pass, $db);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>

