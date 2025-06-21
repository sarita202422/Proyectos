<?php
// Inicia la sesión para poder acceder a las variables de sesión
session_start();

// Verifica si el usuario **NO está autenticado**
// Si no existe la variable de sesión 'user', significa que el usuario no ha iniciado sesión
if (!isset($_SESSION['user'])) {
  
  // Si no está autenticado, lo redirige al login o página principal (en este caso, dashboard.php)
  header("Location: dashboard.php");
  
  // Termina el script para evitar que se ejecute cualquier otro código después de la redirección
  exit;
}
?>