<?php
// Inicia la sesión para mantener la autenticación del usuario
session_start();

// Si no hay un usuario en sesión, redirige al login
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

// Incluye la conexión a la base de datos
include 'db.php';

// Consulta todos los proyectos ordenados desde el más reciente
$result = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <!-- Enlace al archivo de estilos CSS del panel -->
  <link rel="stylesheet" href="../assets/css/Proyecto-integrado-final/dashboard.css">
</head>

<body>
  <!-- Mensaje de bienvenida con el nombre de usuario desde la sesión -->
  <h2>Bienvenido, <?php echo $_SESSION['user']; ?></h2>

  <!-- Botones de acciones principales: agregar proyecto y cerrar sesión -->
  <div class="header-actions">
    <a href="add.php">Agregar nuevo proyecto</a>
    <a href="logout.php" class="logout-button">Cerrar sesión</a>
  </div>

  <h3>Lista de Proyectos</h3>


    <!-- Bucle para recorrer y mostrar todos los proyectos obtenidos -->
  <?php while ($p = $result->fetch_assoc()): ?>
    <div>
      <!-- Título del proyecto con protección contra código malicioso -->
      <h4><?php echo htmlspecialchars($p['titulo']); ?></h4>

      <!-- Descripción del proyecto, conservando los saltos de línea -->
      <p><?php echo nl2br(htmlspecialchars($p['descripcion'])); ?></p>

      <!-- Si hay imagen, se muestra -->
      <?php if (!empty($p['imagen'])): ?>
        <img src="../uploads/<?php echo $p['imagen']; ?>" width="300"><br>
      <?php endif; ?>

      <!-- Enlaces a GitHub y a la URL en producción -->
      <a href="<?php echo $p['url_github']; ?>" target="_blank">GitHub</a><br>
      <a href="<?php echo $p['url_produccion']; ?>" target="_blank">Ver online</a><br>

      <!-- Enlaces para editar o eliminar el proyecto -->
      <a href="edit.php?id=<?php echo $p['id']; ?>">Editar</a> |
      <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirmarEliminacion()">Eliminar</a>

      <hr>
    </div>
  <?php endwhile; ?>
<!-- Script JS con la función para confirmar eliminación -->
  <script src="../assets/js/Proyecto-integrado-final/script.js"></script>
</body>
</html>
