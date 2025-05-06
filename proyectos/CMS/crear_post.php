<?php
// Conectar a la base de datos
include 'conexion.php';

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $contenido = $_POST['contenido'] ?? '';

    if (!empty(trim($titulo)) && !empty(trim($contenido))) {
        // Insertar en la base de datos usando mysqli_query()
        $sql = "INSERT INTO posts (titulo, contenido) VALUES ('$titulo', '$contenido')";

        if (mysqli_query($conn, $sql)) {
            // Redirigir al index después de insertar
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Por favor, completa todos los campos.";
    }
} else {
    echo "Acceso no permitido.";
}
?>

