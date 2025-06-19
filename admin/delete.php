<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("ID inválido.");
}

$id = (int) $_GET['id'];

// Verificar existencia antes de eliminar
$stmt = $conn->prepare("SELECT * FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Proyecto no encontrado.");
}

$stmt = $conn->prepare("DELETE FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: dashboard.php");
exit();
?>
