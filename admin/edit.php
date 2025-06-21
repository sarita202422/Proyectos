<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';

$id = $_GET['id'];
if (!is_numeric($id)) {
  die("ID inválido.");
}

$stmt = $conn->prepare("SELECT * FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$proyecto = $stmt->get_result()->fetch_assoc();

if (!$proyecto) {
  die("Proyecto no encontrado.");
}

$errores = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titulo = trim($_POST['titulo']);
  $descripcion = trim($_POST['descripcion']);
  $url_github = trim($_POST['url_github']);
  $url_produccion = trim($_POST['url_produccion']);

  // Verificaciones básicas
  if (empty($titulo)) $errores[] = "El título no puede estar vacío.";
  if (empty($descripcion)) $errores[] = "La descripción no puede estar vacía.";
  if (strlen($descripcion) > 500) $errores[] = "La descripción no puede tener más de 500 caracteres.";
  
  if (empty($url_github)) {
    $errores[] = "La URL de GitHub es obligatoria.";
  } elseif (!filter_var($url_github, FILTER_VALIDATE_URL)) {
    $errores[] = "La URL de GitHub no es válida.";
  }
  if (empty($url_produccion)) {
    $errores[] = "La URL de Producción es obligatoria.";
  } elseif (!filter_var($url_produccion, FILTER_VALIDATE_URL)) {
    $errores[] = "La URL de Producción no es válida.";
  }

  if (!empty($_FILES['imagen']['name'])) {
    $imagen = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];
    $ext = pathinfo($imagen, PATHINFO_EXTENSION);
    $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array(strtolower($ext), $ext_permitidas)) {
      $errores[] = "Solo se permiten imágenes (jpg, png, gif, webp).";
    }
  }

  // Solo actualiza si no hay errores
  if (empty($errores)) {
    if (!empty($imagen)) {
      move_uploaded_file($tmp, "../uploads/$imagen");

      $stmt = $conn->prepare("UPDATE proyectos SET titulo = ?, descripcion = ?, url_github = ?, url_produccion = ?, imagen = ? WHERE id = ?");
      $stmt->bind_param("sssssi", $titulo, $descripcion, $url_github, $url_produccion, $imagen, $id);
    } else {
      $stmt = $conn->prepare("UPDATE proyectos SET titulo = ?, descripcion = ?, url_github = ?, url_produccion = ? WHERE id = ?");
      $stmt->bind_param("ssssi", $titulo, $descripcion, $url_github, $url_produccion, $id);
    }

    $stmt->execute();
    header("Location: dashboard.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Proyecto</title>
  <link rel="stylesheet" href="../assets/css/Proyecto-integrado-final/edit.css">
</head>
<body>
  <div class="edit-container">
  <h2 class="edit-title">Editar Proyecto</h2>
  <form method="post" enctype="multipart/form-data">

  <?php if (!empty($errores)): ?>
    <ul style="color: red;">
      <?php foreach ($errores as $error): ?>
        <li><?= htmlspecialchars($error) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" onsubmit="return confirmarActualizacion()">
    <input type="text" name="titulo" value="<?= htmlspecialchars($proyecto['titulo']) ?>" required><br>
    <textarea name="descripcion" required><?= htmlspecialchars($proyecto['descripcion']) ?></textarea><br>
    <input type="url" name="url_github" value="<?= htmlspecialchars($proyecto['url_github']) ?>"><br>
    <input type="url" name="url_produccion" value="<?= htmlspecialchars($proyecto['url_produccion']) ?>"><br>
    <p>Imagen actual: <?= $proyecto['imagen'] ?></p>
    <input type="file" name="imagen"><br>
    <button type="submit">Actualizar</button>
  </form>
  <script src="../assets/js/Proyecto-integrado-final/script.js"></script>
</body>
</html>
