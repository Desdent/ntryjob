<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../controllers/admin/AlumnosController.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

// Verificar autenticación y rol
session_start();
AuthMiddleware::requiereAuth(['admin']);

// Instanciar controller
$controller = new AlumnosController();

// Detectar método HTTP y ejecutar
$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $controller->index();
        break;
    case 'POST':
        $controller->create();
        break;
    case 'PUT':
        $controller->update();
        break;
    case 'DELETE':
        $controller->delete();
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}
