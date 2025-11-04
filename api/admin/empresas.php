<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../controllers/admin/EmpresasController.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

// Verificar login y rol
session_start();
AuthMiddleware::requiereAuth(['admin']);

// Instanciar controller
$controlador = new EmpresasController();

// Detectar método HTTP y ejecutar
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        $controlador->index();
        break;
    case 'PUT':
        $controlador->aprobar();
        break;
    case 'DELETE':
        $controlador->delete();
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}
