<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../models/entities/AlumnoEntity.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['admin']);

$dao = new AlumnoDAO();
$method = $_SERVER['REQUEST_METHOD'];

try {
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                $alumno = $dao->getById($_GET['id']);
                echo json_encode($alumno ? $alumno->toArray() : null);
            } else {
                $alumnos = $dao->getAll();
                echo json_encode(array_map(fn($a) => $a->toArray(), $alumnos));
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true) ?: $_POST;
            $alumno = new AlumnoEntity($data);
            $nuevo = $dao->create($alumno);
            echo json_encode(['success' => true, 'id' => $nuevo->id, 'alumno' => $nuevo->toArray()]);
            break;
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            $alumno = new AlumnoEntity($data);
            $dao->update($alumno);
            echo json_encode(['success' => true]);
            break;
        case 'DELETE':
            $id = $_GET['id'] ?? null;
            if ($id) {
                $dao->delete($id);
                echo json_encode(['success' => true]);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Método no permitido']);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}

