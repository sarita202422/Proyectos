<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "blog_db";

// Crear conexión
$conn = mysqli_connect($servername, $username, $password, $database);

// Verificar conexión
if (!$conn) {
    die("Conexión fallida: " . mysqli_connect_error());
}
?>

