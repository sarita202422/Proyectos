<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $_SESSION['user'] = $username;
    header("Location: dashboard.php");
    exit();
  } else {
    $error = "Credenciales incorrectas.";
  }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar Sesión</title>
  <link rel="stylesheet" href="../assets/css/Proyecto-integrado-final/login.css">
</head>
<body>
  <div class="login-container">
    <h2>Iniciar Sesión</h2>
    
    <?php if (!empty($error)) echo "<p style='color: red; text-align: center;'>$error</p>"; ?>
    
    <form method="post">
      <input type="text" name="username" placeholder="Usuario" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <button type="submit">Iniciar Sesión</button>
    </form>
  </div>
</body>
</html>
