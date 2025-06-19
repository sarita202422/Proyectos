<?php
session_start();
session_destroy();
header("Location: ../proyectos/Proyecto-integrado-final/index.html");
exit();
?>