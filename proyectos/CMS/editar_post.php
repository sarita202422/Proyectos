<?php
$conexion = mysqli_connect("teclab.uct.cl", "sarita_marinao", "sarita_marinao2025", "sarita_marinao_db2");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM posts WHERE id = $id";
    $resultado = mysqli_query($conexion, $sql);
    $post = mysqli_fetch_assoc($resultado);
} else {
    echo "ID no válido";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar publicación</title>
    <link rel="stylesheet" href="../../assets/css/CMS/styles.css">
</head>
<body>
    <header>
        <h1>Editar Publicación</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <form action="procesar_edicion.php" method="post">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?= htmlspecialchars($post['titulo']) ?>" required>

            <label for="contenido">Contenido:</label>
            <textarea name="contenido" id="contenido" rows="10" required><?= htmlspecialchars($post['contenido']) ?></textarea>

            <button type="submit">Guardar cambios</button>
        </form>
    </main>

    <footer>
        <p>© 2025 Sarita Marinao - Todos los derechos reservados.</p>
    </footer>
</body>
</html>