<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../controllers/alumno/CVController.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

session_start();
AuthMiddleware::requiereAuth(['alumno']);

$controlador = new CVController();
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        $controlador->show();
        break;
    case 'POST':
        $controlador->upload();
        break;
    case 'DELETE':
        $controlador->delete();
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
}
