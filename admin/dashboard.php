<?php
session_start();
if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  exit();
}

include 'db.php';
$result = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="../assets/css/Proyecto-integrado-final/dashboard.css">
</head>
<body>
  <h2>Bienvenido, <?php echo $_SESSION['user']; ?></h2>
<div class="header-actions">
  <a href="add.php">Agregar nuevo proyecto</a>
  <a href="logout.php" class="logout-button">Cerrar sesión</a>

</div>

  <h3>Lista de Proyectos</h3>

  <?php while ($p = $result->fetch_assoc()): ?>
    <div>
      <h4><?php echo htmlspecialchars($p['titulo']); ?></h4>
      <p><?php echo nl2br(htmlspecialchars($p['descripcion'])); ?></p>
      <?php if (!empty($p['imagen'])): ?>
        <img src="../uploads/<?php echo $p['imagen']; ?>" width="300"><br>
      <?php endif; ?>
      <a href="<?php echo $p['url_github']; ?>" target="_blank">GitHub</a><br>
      <a href="<?php echo $p['url_produccion']; ?>" target="_blank">Ver online</a><br>
      <a href="edit.php?id=<?php echo $p['id']; ?>">Editar</a> |
     <a href="delete.php?id=<?= $p['id'] ?>" onclick="return confirmarEliminacion()">Eliminar</a>
      <hr>
    </div>
  <?php endwhile; ?>
  <script src="../assets/js/Proyecto-integrado-final/script.js"></script>
</body>
</html>
