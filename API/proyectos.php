<?php
// Incluye la configuración de la base de datos
include 'config.php';

// Permitir solicitudes desde cualquier origen (CORS)
header("Access-Control-Allow-Origin: *");

// Especificar que el contenido devuelto será JSON
header("Content-Type: application/json");

// Métodos HTTP permitidos para esta API
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");

// Obtener el método de la solicitud (GET, POST, etc.)
$method = $_SERVER['REQUEST_METHOD'];

// Obtener el ID del recurso si fue enviado en la URL (ej: /proyectos/3)
$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));
$id = isset($request[0]) && is_numeric($request[0]) ? intval($request[0]) : null;

// Función para leer el cuerpo de la petición (JSON) y convertirlo en arreglo PHP
function getInput() {
    return json_decode(file_get_contents("php://input"), true);
}

// Controlador principal: manejar diferentes tipos de solicitud según el método HTTP
switch ($method) {

    // ------------------------- GET -------------------------
    case 'GET':
        if ($id) {
            // Obtener proyecto específico por ID
            $stmt = $conn->prepare("SELECT * FROM proyectos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();

            if ($res->num_rows === 0) {
                http_response_code(404); // No encontrado
                echo json_encode(["error" => "Proyecto no encontrado"]);
            } else {
                http_response_code(200); // OK
                echo json_encode($res->fetch_assoc());
            }

        } else {
            // Obtener todos los proyectos
            $res = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
            $out = [];

            while ($row = $res->fetch_assoc()) {
                $out[] = $row;
            }

            http_response_code(200); // OK
            echo json_encode($out);
        }
        break;

    // ------------------------- POST -------------------------
    case 'POST':
        $d = getInput(); // Datos recibidos

        // Verifica que los campos requeridos estén presentes
        if (!isset($d['titulo'], $d['descripcion'])) {
            http_response_code(400); // Solicitud incorrecta
            echo json_encode(["error" => "Faltan campos requeridos"]);
            break;
        }

        // Insertar nuevo proyecto
        $stmt = $conn->prepare("INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $d['titulo'], $d['descripcion'], $d['url_github'], $d['url_produccion'], $d['imagen']);

        if ($stmt->execute()) {
            http_response_code(201); // Recurso creado
            echo json_encode(["success" => true, "id" => $stmt->insert_id]);
        } else {
            http_response_code(500); // Error del servidor
            echo json_encode(["error" => "Error al crear proyecto"]);
        }
        break;

    // ------------------------- PATCH -------------------------
    case 'PATCH':
        if (!$id) {
            http_response_code(400); // ID no enviado
            echo json_encode(["error" => "ID no proporcionado"]);
            break;
        }

        $d = getInput(); // Datos a actualizar
        if (!$d) {
            http_response_code(400); // Datos inválidos
            echo json_encode(["error" => "Datos inválidos"]);
            break;
        }

        // Preparar la consulta de actualización con los campos recibidos
        $sets = [];
        foreach ($d as $k => $v) {
            $sets[] = "$k = '{$conn->real_escape_string($v)}'";
        }

        // Ejecutar la consulta
        $sql = "UPDATE proyectos SET " . implode(",", $sets) . " WHERE id = $id";

        if ($conn->query($sql)) {
            http_response_code(200); // OK
            echo json_encode(["success" => true]);
        } else {
            http_response_code(500); // Error en servidor
            echo json_encode(["error" => "Error al actualizar"]);
        }
        break;

    // ------------------------- DELETE -------------------------
    case 'DELETE':
        if (!$id) {
            http_response_code(400); // ID no enviado
            echo json_encode(["error" => "ID no proporcionado"]);
            break;
        }

        // Eliminar proyecto por ID
        $stmt = $conn->prepare("DELETE FROM proyectos WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            http_response_code(200); // OK
            echo json_encode(["success" => true]);
        } else {
            http_response_code(500); // Error interno
            echo json_encode(["error" => "Error al eliminar"]);
        }
        break;

    // ------------------------- MÉTODO NO PERMITIDO -------------------------
    default:
        http_response_code(405); // Método no permitido
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
