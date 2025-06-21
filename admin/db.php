<?php
// Datos de conexión a la base de datos
$host = "teclab.uct.cl";              // Dirección del servidor de base de datos
$db   = "sarita_marinao_db1";         // Nombre de la base de datos que se va a usar
$user = "sarita_marinao";             // Usuario autorizado para acceder a la base
$pass = "sarita_marinao2025";         // Contraseña del usuario

// Se crea una nueva conexión usando la clase mysqli
$conn = new mysqli($host, $user, $pass, $db);

// Se verifica si ocurrió un error al conectar
if ($conn->connect_error) {
    // Si hay un error, se detiene la ejecución y muestra el mensaje
    die("Error de conexión: " . $conn->connect_error);
}
?>
