<?php
// Inicia la sesión para poder acceder a los datos de sesión existentes
session_start();

// Destruye toda la información de la sesión actual (cierra sesión)
session_destroy();

// Redirige al usuario a la página principal del portafolio
header("Location: ../proyectos/Proyecto-integrado-final/index.html");

// Finaliza el script para asegurarse de que no se ejecute nada más
exit();
?>
