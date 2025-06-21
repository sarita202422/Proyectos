<?php
// Inicia la sesión para poder almacenar datos del usuario
session_start();

// Incluye el archivo de conexión a la base de datos
include 'db.php';

// Verifica si el formulario fue enviado por método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recupera el nombre de usuario y la contraseña del formulario
  $username = $_POST['username'];
  // Cifra la contraseña usando md5 (aunque hoy en día no es lo más seguro)
  $password = md5($_POST['password']);

  // Consulta SQL para buscar un usuario con esas credenciales
  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  // Si se encuentra un usuario, se inicia sesión y redirige al dashboard
  if ($result->num_rows === 1) {
    $_SESSION['user'] = $username;
    header("Location: dashboard.php");
    exit();
  } else {
    // Si las credenciales son incorrectas, muestra un error
    $error = "Credenciales incorrectas.";
  }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <!-- Enlace al archivo CSS para aplicar estilos al login -->
  <link rel="stylesheet" href="../assets/css/Proyecto-integrado-final/login.css">
</head>
<body>
  <div class="login-container">
    <!-- Título de la página -->
    <h2>Iniciar Sesión</h2>
    
    <!-- Si existe un error, lo muestra en rojo -->
    <?php if (!empty($error)) echo "<p style='color: red; text-align: center;'>$error</p>"; ?>
    
    <!-- Formulario de inicio de sesión -->
    <form method="post">
      <!-- Campo para el nombre de usuario -->
      <input type="text" name="username" placeholder="Usuario" required>
      <!-- Campo para la contraseña -->
      <input type="password" name="password" placeholder="Contraseña" required>
      <!-- Botón para enviar el formulario -->
      <button type="submit">Iniciar Sesión</button>
    </form>
  </div>
</body>
</html>
