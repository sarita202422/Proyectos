<?php
$host = "teclab.uct.cl";
$db = "sarita_marinao_db1";
$user = "sarita_marinao";
$pass = "sarita_marinao2025";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
