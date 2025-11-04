<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../controllers/admin/OfertasController.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['admin']);

$controlador = new OfertasController();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        $controlador->index();
        break;
    case 'POST':
        $controlador->findByEmpresaByID();
        break;
    case 'PUT':
        $controlador->update();
        break;
    case 'DELETE':
        $controlador->delete();
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}
