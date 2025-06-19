<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $titulo = $_POST['titulo'];
  $descripcion = $_POST['descripcion'];
  $url_github = $_POST['url_github'];
  $url_produccion = $_POST['url_produccion'];

  $imagen = $_FILES['imagen']['name'];
  $tmp = $_FILES['imagen']['tmp_name'];
 if (move_uploaded_file($tmp, "../uploads/$imagen")) {
  echo "Imagen subida con éxito.<br>";
} else {
  echo "Error al subir la imagen.<br>";
}

  $sql = "INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) 
          VALUES ('$titulo', '$descripcion', '$url_github', '$url_produccion', '$imagen')";

  $conn->query($sql);
  header("Location: dashboard.php");
}
?>

<form method="post" enctype="multipart/form-data">
  <input type="text" name="titulo" placeholder="Título" required><br>
  <textarea name="descripcion" maxlength="200" placeholder="Descripción (máx 200 palabras)" required></textarea><br>
  <input type="url" name="url_github" placeholder="URL GitHub"><br>
  <input type="url" name="url_produccion" placeholder="URL Producción"><br>
  <input type="file" name="imagen" required><br>
  <button type="submit">Guardar</button>
</form>
  