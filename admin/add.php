<?php
// Inicia la sesión para mantener la autenticación del usuario
session_start();

// Verifica si el usuario está autenticado. Si no lo está, lo redirige al login.
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Conecta a la base de datos
include 'db.php';

// Si el formulario fue enviado mediante POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recibe los datos enviados desde el formulario
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'];
  $url_github = $_POST['url_github'];
  $url_produccion = $_POST['url_produccion'];

  // Recibe el archivo de imagen (nombre original y ubicación temporal)
  $imagen = $_FILES['imagen']['name'];
  $tmp = $_FILES['imagen']['tmp_name'];

  // Intenta mover la imagen subida desde la ubicación temporal a la carpeta de destino
  if (move_uploaded_file($tmp, "../uploads/$imagen")) {
    echo "Imagen subida con éxito.<br>";
  } else {
    echo "Error al subir la imagen.<br>";
  }

  // Crea la consulta SQL para insertar el nuevo proyecto en la base de datos
  $sql = "INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) 
          VALUES ('$titulo', '$descripcion', '$url_github', '$url_produccion', '$imagen')";

  // Ejecuta la consulta en la base de datos
  $conn->query($sql);

  // Redirige al panel de administración después de guardar
  header("Location: dashboard.php");
}
?>

<!-- Estructura básica del HTML -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Proyecto</title>

  <!-- Enlace al archivo de estilos CSS para esta página -->
  <link rel="stylesheet" href="../assets/css/Proyecto-integrado-final/add.css">
</head>
<body>

  <!-- Contenedor principal del formulario -->
  <div class="add-container">

    <!-- Título del formulario -->
    <h2 class="add-title">Agregar Nuevo Proyecto</h2>

    <!-- Formulario para agregar un nuevo proyecto -->
    <!-- method="post" indica que se enviarán datos por POST -->
    <!-- enctype="multipart/form-data" permite subir archivos (en este caso, una imagen) -->
    <form method="post" enctype="multipart/form-data">

      <!-- Campo de texto para el título del proyecto -->
      <input type="text" name="titulo" placeholder="Título" required><br>

      <!-- Campo de texto largo para la descripción -->
      <textarea name="descripcion" maxlength="200" placeholder="Descripción (máx 200 palabras)" required></textarea><br>

      <!-- Campo para URL de GitHub -->
      <input type="url" name="url_github" placeholder="URL GitHub"><br>

      <!-- Campo para URL de la versión en línea del proyecto -->
      <input type="url" name="url_produccion" placeholder="URL Producción"><br>

      <!-- Campo para subir una imagen -->
      <input type="file" name="imagen" required><br>

      <!-- Botón para enviar el formulario -->
      <button type="submit" class="btn-add">Guardar</button>
    </form>
  </div>
</body>
</html>

