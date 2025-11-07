<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../dao/OfertaDAO.php';
require_once __DIR__ . '/../../dao/AlumnoDAO.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['alumno']);

$ofertaDAO = new OfertaDAO();
$alumnoDAO = new AlumnoDAO();
$metodo = $_SERVER['REQUEST_METHOD'];

try {
    switch ($metodo) {
        case 'GET':
            if (isset($_GET["action"]) && $_GET["action"] === "findCiclos") {
                $alumno = $alumnoDAO->findByUsuarioId($_SESSION['user_id']);
                if (!$alumno) {
                    http_response_code(404);
                    echo json_encode(['success' => false, 'error' => 'Alumno no encontrado']);
                    exit;
                }
                $ciclos = $alumnoDAO->getCiclosAlumno($alumno->id);
                echo json_encode(['success' => true, 'ciclos' => $ciclos]);
            } elseif (isset($_GET['ids'])) {
                $ids = $_GET['ids'];
                $ciclosArray = explode(',', $ids);
                $ofertas = $ofertaDAO->getAllByCiclos($ciclosArray);
                echo json_encode(array_map(fn($o) => $o->toArray(), $ofertas));
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Parámetros requeridos']);
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

