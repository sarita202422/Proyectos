<?php
// Inicia sesión para verificar si el usuario está autenticado
session_start();

// Si no hay sesión iniciada, redirige al login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Incluye el archivo con la conexión a la base de datos
include 'db.php';

// Obtiene el ID del proyecto desde la URL
$id = $_GET['id'];

// Verifica que el ID sea numérico
if (!is_numeric($id)) {
  die("ID inválido.");
}

// Consulta para obtener los datos del proyecto según su ID
$stmt = $conn->prepare("SELECT * FROM proyectos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$proyecto = $stmt->get_result()->fetch_assoc();

// Si no se encuentra el proyecto, muestra error
if (!$proyecto) {
  die("Proyecto no encontrado.");
}

// Array para almacenar errores de validación
$errores = [];

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Obtiene y limpia los datos enviados por el formulario
  $titulo = trim($_POST['titulo']);
  $descripcion = trim($_POST['descripcion']);
  $url_github = trim($_POST['url_github']);
  $url_produccion = trim($_POST['url_produccion']);

  // Validaciones
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

  // Validación de imagen si se cargó una nueva
  if (!empty($_FILES['imagen']['name'])) {
    $imagen = $_FILES['imagen']['name'];
    $tmp = $_FILES['imagen']['tmp_name'];
    $ext = pathinfo($imagen, PATHINFO_EXTENSION);
    $ext_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    if (!in_array(strtolower($ext), $ext_permitidas)) {
      $errores[] = "Solo se permiten imágenes (jpg, png, gif, webp).";
    }
  }

  // Si no hay errores, se actualiza el proyecto
  if (empty($errores)) {
    if (!empty($imagen)) {
      // Mueve la nueva imagen al directorio correspondiente
      move_uploaded_file($tmp, "../uploads/$imagen");

      // Consulta para actualizar todos los campos, incluyendo imagen
      $stmt = $conn->prepare("UPDATE proyectos SET titulo = ?, descripcion = ?, url_github = ?, url_produccion = ?, imagen = ? WHERE id = ?");
      $stmt->bind_param("sssssi", $titulo, $descripcion, $url_github, $url_produccion, $imagen, $id);
    } else {
      // Consulta sin cambiar la imagen
      $stmt = $conn->prepare("UPDATE proyectos SET titulo = ?, descripcion = ?, url_github = ?, url_produccion = ? WHERE id = ?");
      $stmt->bind_param("ssssi", $titulo, $descripcion, $url_github, $url_produccion, $id);
    }

    // Ejecuta la actualización y redirige al panel
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
  <!-- Enlace al archivo CSS con los estilos de edición -->
  <link rel="stylesheet" href="../assets/css/Proyecto-integrado-final/edit.css">
</head>
<body>
  <div class="edit-container">
    <!-- Título de la sección -->
    <h2 class="edit-title">Editar Proyecto</h2>

    <!-- Muestra los errores si existen -->
    <?php if (!empty($errores)): ?>
      <ul style="color: red;">
        <?php foreach ($errores as $error): ?>
          <li><?= htmlspecialchars($error) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <!-- Formulario para editar el proyecto -->
    <form method="post" enctype="multipart/form-data" onsubmit="return confirmarActualizacion()">
      <!-- Campo para el título -->
      <input type="text" name="titulo" value="<?= htmlspecialchars($proyecto['titulo']) ?>" required><br>

      <!-- Campo para la descripción -->
      <textarea name="descripcion" required><?= htmlspecialchars($proyecto['descripcion']) ?></textarea><br>

      <!-- Campo para la URL de GitHub -->
      <input type="url" name="url_github" value="<?= htmlspecialchars($proyecto['url_github']) ?>"><br>

      <!-- Campo para la URL de Producción -->
      <input type="url" name="url_produccion" value="<?= htmlspecialchars($proyecto['url_produccion']) ?>"><br>

      <!-- Muestra el nombre de la imagen actual -->
      <p>Imagen actual: <?= $proyecto['imagen'] ?></p>

      <!-- Campo para subir nueva imagen -->
      <input type="file" name="imagen"><br>

      <!-- Botón para enviar el formulario -->
      <button type="submit">Actualizar</button>
    </form>
  </div>

  <!-- Script JS con funciones como confirmación de actualización -->
  <script src="../assets/js/Proyecto-integrado-final/script.js"></script>
</body>
</html>
