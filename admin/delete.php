<?php
// Iniciar sesión para verificar si el usuario está autenticado
session_start();

// Verificar si el usuario ha iniciado sesión, si no, redirigirlo al login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Incluir el archivo de conexión a la base de datos
include 'db.php';

// Validar si se recibió un ID por la URL y si es numérico
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  // Si no es válido, se detiene la ejecución
  die("ID inválido.");
}

// Convertir el ID recibido a tipo entero
$id = (int) $_GET['id'];

// Verificar que el proyecto con ese ID exista antes de eliminarlo
$stmt = $conn->prepare("SELECT * FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);  // "i" indica que el parámetro es un número entero
$stmt->execute();
$result = $stmt->get_result();

// Si no se encuentra el proyecto, se detiene la ejecución con un mensaje
if ($result->num_rows === 0) {
  die("Proyecto no encontrado.");
}

// Preparar la consulta para eliminar el proyecto con el ID especificado
$stmt = $conn->prepare("DELETE FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

// Una vez eliminado, redirigir al panel de administración
header("Location: dashboard.php");
exit();
?>
