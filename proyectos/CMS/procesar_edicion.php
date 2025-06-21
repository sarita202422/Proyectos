<?php
$conexion = mysqli_connect("teclab.uct.cl", "sarita_marinao", "sarita_marinao2025", "sarita_marinao_db2");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $titulo = mysqli_real_escape_string($conexion, $_POST['titulo']);
    $contenido = mysqli_real_escape_string($conexion, $_POST['contenido']);

    $sql = "UPDATE posts SET titulo='$titulo', contenido='$contenido' WHERE id=$id";

    if (mysqli_query($conexion, $sql)) {
        header("Location: index.php");
        exit;
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
} else {
    echo "Acceso no permitido.";
}