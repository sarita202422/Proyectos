<?php
$conexion = new mysqli("teclab.uct.cl", "sarita_marinao", "sarita_marinao2025", "sarita_marinao_db2");

$id = $_GET['id'];
$sql = "SELECT * FROM posts WHERE id = $id";
$resultado = mysqli_query($conexion, $sql);
$post = mysqli_fetch_assoc($resultado);

if ($post) {
    echo "<h2>" . $post['titulo'] . "</h2>";
    echo "<p>" . $post['contenido'] . "</p>";
} else {
    echo "Publicación no encontrada.";
}
?>