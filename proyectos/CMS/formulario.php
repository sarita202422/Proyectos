<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Post</title>
    <link rel="stylesheet" href="../../assets/css/CMS/styles.css">
</head>
<body>
    <header>
        <h1>Crear Nueva Publicación</h1>
        <nav>
            <ul>
                <li><a href="index.php">Inicio</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="formulario-post">
            <h2>Crear nueva publicación</h2>
            <form action="crear_post.php" method="POST">
                <label for="titulo">Título:</label><br>
                <input type="text" id="titulo" name="titulo" required><br><br>

                <label for="contenido">Contenido:</label><br>
                <textarea id="contenido" name="contenido" rows="5" required></textarea><br><br>

                <button type="submit">Publicar</button>
            </form>
        </section>
    </main>

    <footer id="contacto">
    <div class="footer-contacto">
        <h3>Contáctame</h3>
        <p>Correo: smarinao2024@alu.uct.cl</p>
        <p>Teléfono: +56 9 1122 3344</p>
        <p>Dirección: av. alegria 1234</p>
    </div>
    <div class="footer-derechos">
        <p>© 2025 Sarita Marinao - Todos los derechos reservados.</p>
    </div>
    </footer>

</body>
</html>