<?php
$conexion = mysqli_connect("teclab.uct.cl", "sarita_marinao", "sarita_marinao2025", "sarita_marinao_db2");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Verificar si el post existe
    $consulta = "SELECT * FROM posts WHERE id = $id";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        // Si existe, eliminarlo
        $sql = "DELETE FROM posts WHERE id = $id";
        if (mysqli_query($conexion, $sql)) {
            echo "<script>alert('Publicación eliminada correctamente.'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error al eliminar: " . mysqli_error($conexion);
        }
    } else {
        echo "<script>alert('La publicación no existe.'); window.location.href = 'index.php';</script>";
    }
} else {
    echo "<script>alert('ID de publicación no proporcionado.'); window.location.href = 'index.php';</script>";
}

mysqli_close($conexion);
?>