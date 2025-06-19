<?php
include 'config.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, PATCH, DELETE");

$method = $_SERVER['REQUEST_METHOD'];
$request = explode('/', trim($_SERVER['PATH_INFO'] ?? '', '/'));
$id = isset($request[0]) && is_numeric($request[0]) ? intval($request[0]) : null;

function getInput() {
    return json_decode(file_get_contents("php://input"), true);
}

switch ($method) {
    case 'GET':
        if ($id) {
            $stmt = $conn->prepare("SELECT * FROM proyectos WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows === 0) {
                http_response_code(404);
                echo json_encode(["error" => "Proyecto no encontrado"]);
            } else {
                http_response_code(200);
                echo json_encode($res->fetch_assoc());
            }
        } else {
            $res = $conn->query("SELECT * FROM proyectos ORDER BY created_at DESC");
            $out = [];
            while ($row = $res->fetch_assoc()) {
                $out[] = $row;
            }
            http_response_code(200);
            echo json_encode($out);
        }
        break;

    case 'POST':
        $d = getInput();
        if (!isset($d['titulo'], $d['descripcion'])) {
            http_response_code(400);
            echo json_encode(["error" => "Faltan campos requeridos"]);
            break;
        }
        $stmt = $conn->prepare("INSERT INTO proyectos (titulo, descripcion, url_github, url_produccion, imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $d['titulo'], $d['descripcion'], $d['url_github'], $d['url_produccion'], $d['imagen']);
        if ($stmt->execute()) {
            http_response_code(201);
            echo json_encode(["success" => true, "id" => $stmt->insert_id]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al crear proyecto"]);
        }
        break;

    case 'PATCH':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "ID no proporcionado"]);
            break;
        }
        $d = getInput();
        if (!$d) {
            http_response_code(400);
            echo json_encode(["error" => "Datos inválidos"]);
            break;
        }

        $sets = [];
        foreach ($d as $k => $v) {
            $sets[] = "$k = '{$conn->real_escape_string($v)}'";
        }

        $sql = "UPDATE proyectos SET " . implode(",", $sets) . " WHERE id = $id";
        if ($conn->query($sql)) {
            http_response_code(200);
            echo json_encode(["success" => true]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al actualizar"]);
        }
        break;

    case 'DELETE':
        if (!$id) {
            http_response_code(400);
            echo json_encode(["error" => "ID no proporcionado"]);
            break;
        }

        $stmt = $conn->prepare("DELETE FROM proyectos WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            http_response_code(200);
            echo json_encode(["success" => true]);
        } else {
            http_response_code(500);
            echo json_encode(["error" => "Error al eliminar"]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
?>
