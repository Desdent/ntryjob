<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../../controllers/empresario/OfertasController.php';
require_once __DIR__ . '/../../middleware/AuthMiddleware.php';

// Verificar login y rol
session_start();
AuthMiddleware::requiereAuth(['empresario']); 

// Instanciar controller
$controlador = new OfertasController();

// Detectar método HTTP y ejecutar
$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {
    case 'GET':
        $controlador->index();
        break;
    case 'POST':
        $controlador->create();
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

// ESTA TIENE QUE SER PARA VER TUS OFERTAS NO LAS GENERALES
