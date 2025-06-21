<?php
// Permite que este archivo sea accedido desde cualquier origen (dominio), útil para peticiones desde el frontend
header("Access-Control-Allow-Origin: *");

// Indica que la respuesta será en formato JSON
header("Content-Type: application/json");

// Define los métodos HTTP permitidos (útil si más adelante se amplía a POST, PATCH o DELETE)
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");

// ---------- Conexión a la base de datos ----------

// Datos del servidor, base de datos y credenciales
$host = "teclab.uct.cl";               // Dirección del servidor de la base de datos
$db   = "sarita_marinao_db1";          // Nombre de la base de datos
$user = "sarita_marinao";              // Usuario para acceder a la base de datos
$pass = "sarita_marinao2025";          // Contraseña del usuario

// Crear una nueva conexión usando MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Verificar si hubo error en la conexión
if ($conn->connect_error) {
    // Si falla, devolver un mensaje de error en formato JSON
    die(json_encode(["error" => "Conexión fallida"]));
}
?>
